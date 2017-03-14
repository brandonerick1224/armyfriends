<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        Notification::seen();
        $notifications = $user->notifications()->orderBy('updated_at', 'desc')
            ->with('notificable')->take(30)->get();

        return view('notifications.index', compact('user', 'notifications'));
    }
}
