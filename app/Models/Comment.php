<?php

namespace App\Models;

use App\Models\Traits\Notificable;

/**
 * App\Models\Comment
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read \App\Models\User $user
 * @property-read mixed $date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $commentable_id
 * @property string $commentable_type
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comment whereUpdatedAt($value)
 */
class Comment extends Model
{
    use Notificable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Boot the model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->commentable->decrement('comments_count');
        });
    }


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get the user that creates the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Get date
     *
     * @return mixed
     */
    public function getDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Is album mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get commented item Url
     */
    public function getUrl()
    {
        return $this->commentable->getUrl();
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get data for broadcasting
     */
    public function getBroadcastData()
    {
        return [
            'id'       => $this->id,
            'obj_id'   => $this->commentable_id,
            'obj_type' => $this->commentable_type,
            'url'      => $this->getUrl(),
        ];
    }

    /**
     * Get data, formatted for Vue frontend
     */
    public function getData()
    {
        return [
            'id'         => $this->id,
            'obj_id'     => $this->commentable_id,
            'obj_type'   => $this->commentable_type,
            'user_name'  => $this->user->full_name,
            'user_link'  => $this->user->getUrl(),
            'user_image' => $this->user->pictureUrl('thumb'),
            'content'    => $this->content,
            'date'       => $this->date,
            'can_update' => \Gate::allows('update', $this),
            'can_remove' => \Gate::allows('remove', $this),
        ];
    }

    /**
     * Get list data
     *
     * @param bool $commentable
     * @return array
     */
    public function getListData($commentable = true)
    {
        $data = [
            'id'         => $this->id,
            'user'       => $this->user ? $this->user->getShortData() : null,
            'content'    => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
            'can_update' => \Gate::allows('update', $this),
            'can_remove' => \Gate::allows('remove', $this),
        ];

        if ($commentable) {
            $data['commentable_type'] = $this->commentable_type;
            $data['commentable'] = $this->commentable ? $this->commentable->getListData() : null;
        }

        return $data;
    }
}
