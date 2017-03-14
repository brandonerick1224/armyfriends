<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        return view('friends.index', ['user' => $user]);
    }

    /**
     * Friends request
     *
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function request(User $user)
    {
        /** @var User $me */
        $me = auth()->user();

        $friend = $me->friend($user);

        if ($friend) {
            switch ($friend->pivot->status) {
                case 'request':
                    return redirect()->back()->withErrors(trans('friends.already-made-request'));
                case 'requested':
                    return redirect()->back()->withErrors(trans('friends.user-already-made-request'));
                case 'refuse':
                    return redirect()->back()->withErrors(trans('friends.request-refused-by-you'));
                case 'refused':
                    return redirect()->back()->withErrors(trans('friends.request-refused'));
                case 'accept':
                    return redirect()->back()->withErrors(trans('friends.already-friends'));
            }
        }

        Friend::request($user);

        return redirect()->back()->with('success', trans('friends.you-sent-request'));
    }

    /**
     * Accept friend
     *
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function accept(User $user)
    {
        /** @var User $me */
        $me = auth()->user();

        $friend = $me->friend($user);

        if (! $friend || $friend->pivot->status !== 'request') {
            return redirect()->back()->withErrors(trans('friends.no-request'));
        }

        Friend::accept($user);

        return redirect()->back()->with('success', trans('friends.you-accepted-request'));
    }

    /**
     * Refuse friend
     *
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function refuse(User $user)
    {
        /** @var User $me */
        $me = auth()->user();

        $friend = $me->friend($user);

        if (! $friend || $friend->pivot->status !== 'request') {
            return redirect()->back()->withErrors(trans('friends.no-request'));
        }

        Friend::refuse($user);

        return redirect()->back()->with('success', trans('friends.you-refused-request'));
    }

    /**
     * Remove friend
     *
     * @param User $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function remove(User $user)
    {
        /** @var User $me */
        $me = auth()->user();

        $friend = $me->friend($user);

        if (! $friend) {
            return redirect()->back()->withErrors('You are not friends!');
        }

        Friend::remove($user);

        return redirect()->back()->with('success', trans('friends.you-removed-friend'));
    }

    /**
     * Friends Search
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        if (empty($keyword)) {
            return redirect('/friends');
        }

        /** @var User $me */
        $me = auth()->user();

        $friends = $me->friends()
            ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orwhere('email', 'like', '%' . $keyword . '%')
                    ->orwhere('user_profiles.first_name', 'like', '%' . $keyword . '%')
                    ->orwhere('user_profiles.last_name', 'like', '%' . $keyword . '%')
                    ->orwhere('user_profiles.city', 'like', '%' . $keyword . '%')
                    ->orwhere('user_profiles.service_city', 'like', '%' . $keyword . '%');
            })->get();

        return view('friends.search', [
            'user'    => $me,
            'friends' => $friends,
        ]);
    }
}
