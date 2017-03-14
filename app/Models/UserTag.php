<?php

namespace App\Models;

use App\Models\Traits\Notificable;

/**
 * App\Models\UserTag
 *
 * @property-read \App\Models\Media $media
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $media_id
 * @property float $x
 * @property float $y
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereMediaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereX($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereY($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserTag whereUpdatedAt($value)
 */
class UserTag extends Model
{
    use Notificable;

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
        'user_id'  => 'int',
        'media_id' => 'int',
        'x'        => 'float',
        'y'        => 'float',
    ];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Get owning user taggable model
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    /**
     * Like belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get tag data
     */
    public function getData()
    {
        return [
            'id'      => $this->id,
            'user_id' => $this->user->id,
            'title'   => $this->user->full_name,
            'link'    => url('profile/' . $this->user->id),
            'image'   => $this->user->pictureUrl('thumb'),
            'x'       => $this->x,
            'y'       => $this->y,
        ];
    }

    /**
     * Get data for broadcasting
     */
    public function getBroadcastData()
    {
        return [
            'user'  => $this->user->getBroadcastData(),
            'image' => $this->media->model->getUrl(),
        ];
    }

    /**
     * Get list data
     */
    public function getListData()
    {
        return [
            'id'         => $this->id,
            'user'       => $this->user ? $this->user->getShortData() : null,
            'x'          => $this->x,
            'y'          => $this->y,
            'can_untag'  => \Gate::allows('untag', $this),
        ];
    }
}
