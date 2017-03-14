<?php

namespace App\Events;

use App\Models\Friend;
use App\Models\GroupUser;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserTag;

class NotificationEvent extends BroadcastToUserEvent
{
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
     * User that sent notification
     *
     * @var User
     */
    public $from;

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
        $this->from = auth()->user();
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
            'user'        => $me->getBroadcastData(),
            'object_type' => $this->object->getTable(),
            'object'      => $this->object->getBroadcastData(),
            'message'     => $this->getMessage(),
            'unread'      => $this->getUnread(),
            'total'       => $this->user->notifications()->where('seen', 0)->count() + 1,
        ];
    }

    /**
     * Get unread count, depends on type
     */
    public function getUnread()
    {
        switch ($this->object->getTable()) {
            case 'friends':
                return $this->user->friends_requests()->count();
            default:
                return null;
        }
    }

    /**
     * Get notification message
     */
    public function getMessage()
    {
        $type = $this->object->getTable();
        $method = 'get' . studly_case($type) . 'Message';
        if (! method_exists($this, $method)) {
            throw new \InvalidArgumentException('Method for ' . $type . ' is not defined.');
        }

        // Set locale temporarily to destination user's locale
        $locale = get_locale();
        set_locale($this->user->locale);

        $message = $this->$method($this->object);

        set_locale($locale);

        return $message;
    }

    /**
     * Get message user
     *
     * @return string
     */
    protected function getMessageUser()
    {
        return '<a href="' . $this->from->getUrl() . '"><img class="notify-user-image" src="'
               . $this->from->pictureUrl('thumb') . '" alt="">' . $this->from->full_name . '</a>';
    }

    /**
     * Get comments type message
     *
     * @param $comment
     * @return string
     */
    protected function getCommentsMessage($comment)
    {
        $message = $this->getMessageUser() . ' ' . trans('notifications.commented-on') . ' ';
        $url = $comment->commentable->getUrl();

        switch ($comment->commentable_type) {
            case 'album_items':
                $message .= '<a href="' . $url . '">' . trans('notifications.image') . '</a>';
                break;
            case 'posts':
                $message .= '<a href="' . $url . '">' . trans('notifications.post') . '</a>';
        }
        return $message;
    }

    /**
     * Get comments type message
     *
     * @param $like
     * @return string
     */
    protected function getLikesMessage($like)
    {
        $message = $this->getMessageUser() . ' ' . trans('notifications.liked-your') . ' ';
        $url = $like->likeable->getUrl();

        switch ($like->likeable_type) {
            case 'album_items':
                $message .= '<a href="' . $url . '">' . trans('notifications.image') . '</a>';
                break;
            case 'posts':
                $message .= '<a href="' . $url . '">' . trans('notifications.post') . '</a>';
        }
        return $message;
    }

    /**
     * Get friends message
     *
     * @param Friend $friend
     * @return string
     */
    protected function getFriendsMessage($friend)
    {
        $message = $this->getMessageUser() . ' ';

        switch ($friend->status) {
            case 'request':
                return $message . trans('notifications.sent-you-friend-request');
            case 'accept':
                return $message . trans('notifications.accepted-friend-request');
            case 'refuse':
                return $message . trans('notifications.refused-friend-request');
        }
    }

    /**
     * Get group message
     *
     * @param GroupUser $groupUser
     * @return string
     */
    protected function getGroupUserMessage($groupUser)
    {
        $message = '';

        if ($groupUser->user_id === $this->user->id) {

            if ($groupUser->status === 'accept') {
                $message .= trans('notifications.you-accepted-to-join');
            } else {
                $message .= trans('notifications.you-invited-to-join');
            }

        } else {
            $message .= $this->getMessageUser() . ' ';

            if ($groupUser->status === 'accept') {
                $message .= trans('notifications.joined');
            } else {
                $message .= trans('groups.requested-to-join');
            }
        }

        $message .= ' <a href="' . $groupUser->group->getUrl() . '">' . $groupUser->group->title . '</a>';

        return $message;
    }

    /**
     * Get group message
     *
     * @param UserProfile $profile
     * @return string
     */
    protected function getUserProfilesMessage($profile)
    {
        $message = $this->getMessageUser() . ' ';

        if (array_get($this->data, 'type') === 'birthday') {
            $message .= trans('notifications.will-have-birthday-in', ['days' => 3])
                        . '(' . $profile->birth_date->format('m/d') . ')';
        }

        return $message;
    }

    /**
     * Get group message
     *
     * @param UserTag $userTag
     * @return string
     */
    protected function getUserTagsMessage($userTag)
    {
        return trans('notifications.you-tagged-on')
               . ' <a href="' . url('album_items/view/' . $userTag->media->model_id) . '">'
               . trans('notifications.image') . '</a>';
    }
}
