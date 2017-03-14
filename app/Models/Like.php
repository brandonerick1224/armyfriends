<?php

namespace App\Models;

use App\Models\Traits\Notificable;

/**
 * App\Models\Like
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $likeable
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $likeable_id
 * @property string $likeable_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereLikeableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereLikeableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like whereUpdatedAt($value)
 */
class Like extends Model
{
    use Notificable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'likeable_id', 'likeable_type'];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Get owning likeable model
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * Like belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get liked item Url
     */
    public function getUrl()
    {
        return $this->likeable->getUrl();
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
            'type' => $this->likeable_type,
            'url'  => $this->getUrl(),
        ];
    }

    /**
     * Get list data
     *
     * @param bool $likeabe
     * @return array
     */
    public function getListData($likeabe = true)
    {
        $data = [
            'user'          => $this->user ? $this->user->getShortData() : null,
            'created_at'    => $this->created_at->toDateTimeString(),
        ];

        if ($likeabe) {
            $data['likeable_type'] = $this->likeable_type;
            $data['likeable'] = $this->likeable ? $this->likeable->getListData() : null;
        }

        return $data;
    }
}
