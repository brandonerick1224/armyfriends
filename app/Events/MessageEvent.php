<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class MessageEvent extends BroadcastToUserEvent
{
    use SerializesModels;

    /**
     * Object that event describes
     *
     * @var object
     */
    public $object;

    /**
     * User that have to be notified
     *
     * @var User
     */
    public $user;

    /**
     * Additional data
     *
     * @var User
     */
    public $data;

    /**
     * Create a new event instance.
     *
     * @param object $object Object that event describes
     * @param User   $user   User that have to be notified
     * @param null   $data   Additional data
     */
    public function __construct($object, User $user, $data = null)
    {
        $this->object = $object;
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Get data for broadcasting
     */
    public function getData()
    {
        /** @var User $me */
        $me = auth()->user();

        return [
            'user'    => $me->getBroadcastData(),
            'object'  => $this->object->getBroadcastData(),
            'message' => $this->getMessage(),
            'unread'  => Chat::myChats($this->user)->notSeen($this->user)->count(),
        ];
    }

    /**
     * Get notification message
     */
    public function getMessage()
    {
        /** @var User $me */
        $me = auth()->user();

        // Set locale temporarily to destination user's locale
        $locale = get_locale();
        set_locale($this->user->locale);

        $message = '<a href="' . $me->getUrl() . '"><img class="notify-user-image" src="' . $me->pictureUrl('thumb') . '" alt="">'
                   . $me->full_name . '</a> ' . trans('notifications.sent-you')
                   . ' <a href="' . url('messages/chat/' . $me->id . '#message-' . $this->object->id) . '">' . trans('notifications.message') . '</a>';

        set_locale($locale);

        return $message;
    }
}
