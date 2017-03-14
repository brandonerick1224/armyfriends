<?php

namespace App\Http\ViewComposers;

use App\Models\Chat;
use Illuminate\View\View;

class HomeBannerComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        /** @var User $me */
        $me = auth()->user();
        $view->with('friends_requests_count', $me->friends_requests()->count());
        $view->with('notifications_count', $me->notifications()->where('seen', 0)->count());
        $view->with('chats_count', Chat::myChats()->notSeen()->count());
    }
}