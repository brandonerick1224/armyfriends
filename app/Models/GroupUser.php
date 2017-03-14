<?php

namespace App\Models;

use App\Models\Traits\Notificable;

/**
 * App\Models\GroupUser
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Group $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $group_id
 * @property integer $user_id
 * @property string $type
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GroupUser whereUpdatedAt($value)
 */
class GroupUser extends Model
{
    use Notificable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_user';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id'   => 'int',
        'group_id'  => 'int',
    ];


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
     * Get group page Url
     */
    public function getGroupUrl()
    {
        return url('groups/view/' . $this->group_id);
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
            'id'     => $this->id,
            'user'   => $this->user->getBroadcastData(),
            'status' => $this->status,
            'url'    => $this->getGroupUrl(),
        ];
    }

    /**
     * Get short data
     */
    public function getShortData()
    {
        return [
            'id'         => $this->id,
            'status'     => $this->status,
            'type'       => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
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
            'status'     => $this->status,
            'type'       => $this->type,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
