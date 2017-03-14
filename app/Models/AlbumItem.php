<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;
use App\Models\Traits\Subscribable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Models\AlbumItem
 *
 * @property-read \App\Models\Album $album
 * @property-read mixed $user_id
 * @property-read mixed $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read mixed $liked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $subscribers
 * @property-read mixed $subscribed
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereLikedBy($userId = null)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $album_id
 * @property integer $order
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $likes_count
 * @property integer $comments_count
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereAlbumId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereLikesCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AlbumItem whereCommentsCount($value)
 */
class AlbumItem extends Model implements HasMediaConversions
{
    use Commentable, HasMediaTrait, Likeable, Subscribable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media', 'album'];

    /**
     * Next item
     *
     * @var self
     */
    protected $next = null;

    /**
     * Previos item
     *
     * @var self
     */
    protected $prev = null;


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Album of this image
     */
    public function album()
    {
        return $this->belongsTo(Album::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Get user_id
     *
     * @return mixed
     */
    public function getUserIdAttribute()
    {
        return $this->album->user_id;
    }

    /**
     * Get user
     *
     * @return mixed
     */
    public function getUserAttribute()
    {
        return $this->album->user;
    }

    /**
     * Media files conversion
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
             ->setManipulations(['w' => 250, 'h' => 250, 'fit' => 'crop'])
             ->performOnCollections('default');
    }

    /**
     * Get next item from album
     */
    public function next()
    {
        if ($this->next) {
            return $this->next;
        }

        return $this->next = self::where('id', '>', $this->id)
            ->where('album_id', $this->album_id)
            ->orderBy('id', 'asc')->first();
    }

    /**
     * Get prev item from album
     */
    public function prev()
    {
        if ($this->prev) {
            return $this->prev;
        }

        return $this->prev = self::where('id', '<', $this->id)
            ->where('album_id', $this->album_id)
            ->orderBy('id', 'desc')->first();
    }

    /**
     * Is album item mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->album->user_id === auth()->id();
    }

    /**
     * Get user tags data
     *
     * @return array
     */
    public function getUserTagsData()
    {
        $tags = collect();
        $media = $this->getFirstMedia();
        if (! $media) {
            return $tags;
        }

        foreach ($media->user_tags as $tag) {
            /** @var UserTag $tag */
            $tags->push($tag->getData());
        }

        return $tags;
    }

    /**
     * Get single item page URL
     */
    public function getUrl()
    {
        return url('album_items/view/' . $this->id);
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get list data
     */
    public function getListData()
    {
        return [
            'id'             => $this->id,
            'album_id'       => $this->album_id,
            'title'          => $this->title,
            'thumb_url'      => url($this->getFirstMediaUrl('default', 'thumb')),
            'comments_count' => $this->comments_count,
            'likes_count'    => $this->likes_count,
            'created_at'     => $this->created_at->toDateTimeString(),
            'liked'          => $this->liked(),
            'can_update'     => \Gate::allows('update', $this),
            'can_remove'     => \Gate::allows('remove', $this),
        ];
    }

    /**
     * Get public data
     *
     * @return array
     */
    public function getPublicData()
    {
        $user = auth()->user();

        return array_merge($this->getListData(), [
            'full_url'           => url($this->getFirstMediaUrl()),
            'user_tags'          => $this->getFirstMedia()->user_tags->map(function (UserTag $tag) {
                return $tag->getListData();
            }),
            'is_profile'         => $this->getFirstMedia()->id === $user->picture_media_id,
            'can_set_as_profile' => \Gate::allows('as-profile', $this),
        ]);
    }
}
