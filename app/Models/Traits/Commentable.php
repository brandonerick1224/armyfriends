<?php

namespace App\Models\Traits;

use App\Events\CommentEvent;
use App\Events\NotificationEvent;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Collection;

trait Commentable
{
    /**
     * Should be removed on model delete
     *
     * @var bool
     */
    protected static $removeCommentsOnDelete = true;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    public static function bootCommentable()
    {
        if (static::$removeCommentsOnDelete) {
            static::deleting(function ($model) {
                $model->removeComments();
            });
        }
    }

    /**
     * Delete likes related to the current record
     */
    public function removeComments()
    {
        foreach ($this->comments as $comment) {
            $comment->delete();
        }
    }

    /**
     * Get all of the model's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }


    /**
     * Data, formatted for Vue frontend
     *
     * @param $lastId
     * @return Collection
     */
    public function getVueComments($lastId = null)
    {
        $builder = $this->comments()->orderBy('created_at', 'desc');

        if (null !== $lastId) {
            $builder->where('id', '<', $lastId);
        }

        $comments = $builder->take(15)->get();

        $data = [
            'total' => $this->comments()->count(),
            'items' => [],
        ];

        foreach ($comments as $comment) {
            /** @var Comment $comment */
            $data['items'][] = $comment->getData();
        }

        $data['items'] = array_reverse($data['items']);

        return new Collection($data);
    }

    /**
     * Add comment
     *
     * @param $content
     * @return Comment
     */
    public function comment($content)
    {
        $comment = $this->comments()->create([
            'user_id' => auth()->id(),
            'content' => $content,
        ]);

        $this->increment('comments_count');

        $this->notifyComment($comment);

        return $comment;
    }

    /**
     * Send notifications
     *
     * @param $comment
     */
    protected function notifyComment($comment)
    {
        /** @var User $me */
        $me = auth()->user();

        // Send notification to owner if he is not who's commenting
        if ($me->id !== $this->user->id) {
            event(new NotificationEvent($comment, $this->user));
        }

        event(new CommentEvent($comment, 'create'));

        // Send notifications to all subscribed users
        foreach ($this->subscribers as $subscriber) {
            // Skip Owner
            if ($subscriber->id === $this->user->id) {
                continue;
            }

            event(new NotificationEvent($comment, $subscriber));
        }
    }
}
