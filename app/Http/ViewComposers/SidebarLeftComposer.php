<?php

namespace App\Http\ViewComposers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class SidebarLeftComposer
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

        /** @var Collection $friendsOfFriends */
        $friendsOfFriends = User::friendsOfFriends($me)->take(10)->get();

        $exclude = $me->friends->pluck('id')
            ->merge($friendsOfFriends->pluck('id'))
            ->merge([$me->id])
            ->unique();

        $servedMatches = User::whereNotIn('id', $exclude)
            ->whereHas('profile', function ($query) use ($me) {
                $query->where('service_country_id', '=', $me->profile->service_country_id)
                      ->where('service_city', '=', $me->profile->service_city);
            })->take(10)->get();

        $users = $friendsOfFriends->merge($servedMatches);

        $view->with([
            'users' => $users,
        ]);
    }
}