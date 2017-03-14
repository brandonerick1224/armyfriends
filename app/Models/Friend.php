<?php

namespace App\Models;

use App\Events\NotificationEvent;
use App\Models\Traits\Notificable;

/**
 * Class Friend
 *
 * @property User $user_from
 * @property User $user_to
 * @package App\Models
 * @property-read \App\Models\User $user
 * @property-read \App\Models\User $friend
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereFriendId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Friend whereUpdatedAt($value)
 */
class Friend extends Model
{
    use Notificable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'        => 'int',
        'user_id'   => 'int',
        'friend_id' => 'int',
    ];


    /* ========================================================================= *\
        Relations
    \* ========================================================================= */

    /**
     * From user
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * To friend
     */
    public function friend()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }


    /* ========================================================================= *\
     * Friends queries
    \* ========================================================================= */

    /**
     * Make friend request
     *
     * @param $user
     * @return self
     */
    public static function request($user)
    {
        $me = auth()->user();

        \DB::beginTransaction();

        $friend = self::create([
            'user_id'   => $me->id,
            'friend_id' => $user->id,
            'status'    => 'requested',
        ]);

        $friendOf = self::create([
            'user_id'   => $user->id,
            'friend_id' => $me->id,
            'status'    => 'request',
        ]);

        event(new NotificationEvent($friendOf, $user));

        \DB::commit();
    }

    /**
     * Accept friend request
     *
     * @param $user
     */
    public static function accept($user)
    {
        $me = auth()->user();

        \DB::beginTransaction();

        $friend = self::where([
            'user_id'   => $me->id,
            'friend_id' => $user->id,
            'status'    => 'request',
        ])->first();
        $friend->update(['status' => 'accept']);

        $friendOf = self::where([
            'user_id'   => $user->id,
            'friend_id' => $me->id,
            'status'    => 'requested',
        ])->first();
        $friendOf->update(['status' => 'accept']);

        event(new NotificationEvent($friendOf, $user));

        \DB::commit();
    }

    /**
     * Refuse friend request
     *
     * @param $user
     */
    public static function refuse($user)
    {
        $me = auth()->user();

        \DB::beginTransaction();

        $friend = self::where([
            'user_id'   => $me->id,
            'friend_id' => $user->id,
            'status'    => 'request',
        ])->first();
        $friend->update(['status' => 'refuse']);

        $friendOf = self::where([
            'user_id'   => $user->id,
            'friend_id' => $me->id,
            'status'    => 'requested',
        ])->first();
        $friendOf->update(['status' => 'refused']);

        event(new NotificationEvent($friendOf, $user));

        \DB::commit();
    }

    /**
     * Remove friend records
     *
     * @param $user
     */
    public static function remove($user)
    {
        $me = auth()->user();

        \DB::beginTransaction();

        $friend = self::where([
            'user_id'   => $me->id,
            'friend_id' => $user->id,
        ])->first()->delete();

        $friendOf = self::where([
            'user_id'   => $user->id,
            'friend_id' => $me->id,
        ])->first()->delete();

        \DB::commit();
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
            'friend' => $this->friend->getBroadcastData(),
            'status' => $this->status,
        ];
    }

    /**
     * Get list data
     *
     * @return array
     */
    public function getListData()
    {
        return [
            'id'          => $this->id,
            'friend'      => $this->friend ? $this->friend->getShortData() : null,
            'status'      => $this->status,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
