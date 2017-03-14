<?php

namespace App\Models;

use App\Models\Traits\Notificable;

/**
 * App\Models\Message
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Chat $chat
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $chat_id
 * @property integer $user_id
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereChatId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message whereUpdatedAt($value)
 */
class Message extends Model
{
    use Notificable;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Unsee chat for another user on new message created
        static::created(function ($model) {
            $me   = auth()->user();
            $chat = $model->chat;

            if ($me->id === $chat->user_one_id) {
                $chat->update(['seen_two' => 0]);
            } else {
                $chat->update(['seen_one' => 0]);
            }
        });
    }

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['user', 'chat'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];


    /* ========================================================================= *\
        Relations
    \* ========================================================================= */

    /**
     * Message author
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Private chat
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Is post mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get chat Url
     */
    public function getUrl()
    {
        /** @var User $me */
        $me = auth()->user();

        return url('messages/chat/'
                   . ($me->id == $this->chat->user_one_id ? $this->chat->user_two_id : $this->chat->user_one_id))
                   . '#message-' . $this->id;
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
            'id'         => $this->id,
            'chat_id'    => $this->chat_id,
            'message'    => $this->message,
            'created_at' => $this->created_at->toDateTimeString(),
            'url'        => $this->getUrl(),
        ];
    }

    /**
     * Get data for broadcasting
     */
    public function getFullData()
    {
        return [
            'id'      => $this->id,
            'message' => $this->message,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
