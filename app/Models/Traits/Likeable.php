<?php

namespace App\Models\Traits;

use App\Events\NotificationEvent;
use App\Models\Like;

trait Likeable
{
    /**
     * Should be removed on model delete
     *
     * @var bool
     */
    protected static $removeLikesOnDelete = true;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    public static function bootLikeable()
    {
        if (static::$removeLikesOnDelete) {
            static::deleting(function ($model) {
                $model->removeLikes();
            });
        }
    }

    /**
     * Delete likes related to the current record
     */
    public function removeLikes()
    {
        foreach ($this->likes as $like) {
            $like->delete();
        }
    }

    /**
     * Fetch records that are liked by a given user.
     * Ex: Book::whereLikedBy(123)->get();
     */
    public function scopeWhereLikedBy($query, $userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        return $query->whereHas('likes', function ($q) use ($userId) {
            $q->where('user_id', '=', $userId);
        });
    }

    /**
     * Collection of the likes on this record
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Add a like for this record by the given user.
     *
     * @param $user mixed - If null will use currently logged in user.
     * @throws
     */
    public function like($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        $like = $this->likes()->where('user_id', '=', $user->id)->first();

        if ($like) {
            return;
        }

        $like = $this->likes()->create(['user_id' => $user->id]);

        // Send event if it's not our item
        if (! $this->mine()) {
            event(new NotificationEvent($like, $this->user));
        }

        $this->increment('likes_count');
    }

    /**
     * Remove a like from this record for the given user.
     *
     * @param $user mixed - If null will use currently logged in user.
     * @throws
     */
    public function unlike($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        $like = $this->likes()->where('user_id', '=', $user->id)->first();

        if (! $like) {
            return;
        }

        $like->delete();

        if ($this->likes_count > 0) {
            $this->decrement('likes_count');
        }
    }

    /**
     * Has the currently logged in user already "liked" the current object
     *
     * @param string $user
     * @return boolean
     */
    public function liked($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }
        if (! $user) {
            return false;
        }

        return (bool) $this->likes()->where('user_id', '=', $user->id)->count();
    }

    /**
     * Did the currently logged in user like this model
     * Example : if($book->liked) { }
     *
     * @return boolean
     */
    public function getLikedAttribute()
    {
        return $this->liked();
    }
}