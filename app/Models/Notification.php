<?php

namespace App\Models;

/**
 * App\Models\Notification
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $notificable
 * @property-read mixed $date
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $notificable_id
 * @property string $notificable_type
 * @property boolean $seen
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereNotificableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereNotificableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereSeen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notification whereUpdatedAt($value)
 */
class Notification extends Model
{
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
        'data'    => 'array',
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
     * Get owning notificable model
     */
    public function notificable()
    {
        return $this->morphTo();
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
     * Set notifications as seen
     *
     * @param null $user
     */
    public static function seen($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }
        
        \DB::table('notifications')->where([
            'user_id' => $user->id,
            'seen'    => 0,
        ])->update(['seen' => 1]);
    }

    /**
     * Get notified item Url
     */
    public function getUrl()
    {
        return $this->notificable->getUrl();
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get list data
     *
     * @return array
     */
    public function getListData()
    {
        return [
            'id'               => $this->id,
            'notificable_type' => $this->notificable_type,
            'notificable'      => $this->notificable ? $this->notificable->getListData() : null,
            'seen'             => $this->seen,
            'data'             => $this->data,
            'created_at'       => $this->created_at->toDateTimeString(),
        ];
    }
}
