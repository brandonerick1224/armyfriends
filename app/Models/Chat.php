<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * App\Models\Chat
 *
 * @property-read \App\Models\User $user_one
 * @property-read \App\Models\User $user_two
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read mixed $user
 * @property-read mixed $seen
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat notSeen($user = null)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_one_id
 * @property integer $user_two_id
 * @property string $last_message_at
 * @property boolean $seen_one
 * @property boolean $seen_two
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereUserOneId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereUserTwoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereLastMessageAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereSeenOne($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereSeenTwo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Chat whereUpdatedAt($value)
 */
class Chat extends Model
{
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
        'user_one_id' => 'integer',
        'user_two_id' => 'integer',
    ];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * From user
     */
    public function user_one()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    /**
     * To user
     */
    public function user_two()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    /**
     * Messages
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Get user
     */
    public function getUserAttribute()
    {
        if (auth()->id() === $this->user_one_id) {
            return $this->user_two;
        }

        return $this->user_one;
    }

    /**
     * If chat seen
     */
    public function getSeenAttribute()
    {
        if (auth()->id() === $this->user_one_id) {
            return $this->seen_one;
        }

        return $this->seen_two;
    }

    /**
     * Scope a query to get online users
     *
     * @param Builder $query
     * @param null    $user
     * @return Builder
     */
    public function scopeNotSeen($query, $user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        return $query->where(function ($query) use ($user) {
            $query->where('user_one_id', $user->id)->where('seen_one', 0);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_two_id', $user->id)->where('seen_two', 0);
        });
    }

    /**
     * See the chat
     */
    public function see()
    {
        $me = auth()->user();

        if ($me->id === $this->user_one_id) {
            $this->update(['seen_one' =>1]);
        } else {
            $this->update(['seen_two' => 1]);
        }
    }

    /**
     * Get chat with user
     *
     * @param $user
     * @return Chat|null
     */
    public static function getChat($user)
    {
        $me = auth()->user();

        return self::where([
            'user_one_id' => $me->id,
            'user_two_id' => $user->id,
        ])->orWhere([
            'user_one_id' => $user->id,
            'user_two_id' => $me->id,
        ])->first();
    }

    /**
     * My chats query
     *
     * @param User $user
     * @return $this
     */
    public static function myChats(User $user = null)
    {
        if (null === $user) {
            /** @var User $user */
            $user = auth()->user();
        }

        return self::where(function ($query) use ($user) {
            $query->where('user_one_id', $user->id)
                ->orWhere('user_two_id', $user->id);
        });
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
            'id'         => $this->id,
            'user'       => $this->user ? $this->user->getShortData() : null,
            'seen'       => $this->seen,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    /**
     * Get full data
     *
     * @param int $offset
     * @return array
     */
    public function getFullData($offset = 0)
    {
        return [
            'id'         => $this->id,
            'user'       => $this->user ? $this->user->getShortData() : null,
            'seen'       => $this->seen,
            'updated_at' => $this->updated_at->toDateTimeString(),
            'messages'   => $this->messages()->orderBy('created_at', 'desc')->take(30)->skip($offset)->get()->map(function (Message $messsage) {
                return $messsage->getFullData();
            })
        ];
    }
}
