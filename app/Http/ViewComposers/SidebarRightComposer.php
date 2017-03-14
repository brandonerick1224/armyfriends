<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class SidebarRightComposer
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
        $view->with('friends', $me->friends()->online()->orderBy('users.last_online', 'desc')->get());
        $view->with('albums', $me->albums()->take(6)->get());
    }
}