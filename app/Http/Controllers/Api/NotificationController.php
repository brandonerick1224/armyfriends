<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Chat;
use App\Models\Notification;
use App\Models\User;

class NotificationController extends Controller
{
    /**
     * Notifications status
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function status()
    {
        /** @var User $me */
        $me = auth()->user();

        return api_response([
            'friend_requests' => $me->friends_requests()->count(),
            'unread_notifications' => $me->notifications()->where('seen', 0)->count(),
            'unread_chats' => Chat::myChats($me)->notSeen()->count(),
        ]);
    }

    /**
     * Notifications list
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function notifications()
    {
        /** @var User $me */
        $me = auth()->user();

        $notifications = $me->notifications()->orderBy('updated_at', 'desc')->with('notificable')->take(30)->get();

        Notification::seen($me);

        return api_response([
            'notifications' => $notifications->map(function (Notification $notification) {
                return $notification->getListData();
            }),
        ]);
    }
}
