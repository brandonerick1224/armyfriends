<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;
use App\Models\Traits\Subscribable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Models\Post
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read mixed $liked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $subscribers
 * @property-read mixed $subscribed
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereLikedBy($userId = null)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $group_id
 * @property string $title
 * @property string $content
 * @property integer $likes_count
 * @property integer $comments_count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereLikesCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereCommentsCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Post whereUpdatedAt($value)
 */
class Post extends Model implements HasMediaConversions
{
    use Commentable, Likeable, HasMediaTrait, Subscribable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'group_id' => 'integer',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['group'];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to group
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Is album mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->user_id === auth()->id();
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

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
     * Get single post page URL
     */
    public function getUrl()
    {
        return url('posts/view/' . $this->id);
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
            'user'           => $this->user ? $this->user->getShortData() : null,
            'group'          => $this->group ? $this->group->getListData() : null,
            'content_short'  => str_limit($this->content),
            'image'          => $this->getFirstMediaUrl() ? url($this->getFirstMediaUrl()) : null,
            'likes_count'    => $this->likes_count,
            'comments_count' => $this->comments_count,
            'created_at'     => $this->created_at->toDateTimeString(),
            'liked'          => $this->liked(),
            'can_update'     => \Gate::allows('update', $this),
            'can_remove'     => \Gate::allows('remove', $this),
        ];
    }

    /**
     * Get public data
     */
    public function getPublicData()
    {
        return array_merge($this->getListData(), [
            'content'  => $this->content,
            'comments' => $this->comments()->orderBy('created_at', 'desc')
                ->take(30)->get()->map(function (Comment $comment) {
                    return $comment->getListData(false);
                }),
        ]);
    }
}
