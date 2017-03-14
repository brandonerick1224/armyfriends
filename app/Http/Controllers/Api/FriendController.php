<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Requests;
use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
    /**
     * Show friends list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function friends(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $friends = $me->friends()->take(30)->skip($request->get('offset'))->get();
        $requests = $me->friends_requests()->take(30)->skip($request->get('offset'))->get();
        $requests_sent = $me->friends_sent_requests()->take(30)->skip($request->get('offset'))->get();

        return api_response([
            'friends'       => $friends->map(function ($user) { return $user->getShortData(); }),
            'requests'      => $requests->map(function ($user) { return $user->getShortData(); }),
            'requests_sent' => $requests_sent->map(function ($user) { return $user->getShortData(); }),
        ]);
    }

    /**
     * Friend request
     *
     * @param Request $request
     * @return $this|\App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function request(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        /** @var User $me */
        $me = auth()->user();
        $user = User::find($request->get('user_id'));
        $friend = $me->friend($user);

        if ($friend) {
            switch ($friend->pivot->status) {
                case 'request':
                    throw new ApiException(trans('friends.already-made-request'));
                case 'requested':
                    throw new ApiException(trans('friends.user-already-made-request'));
                case 'refuse':
                    throw new ApiException(trans('friends.request-refused-by-you'));
                case 'refused':
                    throw new ApiException(trans('friends.request-refused'));
                case 'accept':
                    throw new ApiException(trans('friends.already-friends'));
            }
        }

        Friend::request($user);

        return api_response();
    }


    /**
     * Accept friend
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws ApiException
     */
    public function accept(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        /** @var User $me */
        $me = auth()->user();
        $user = User::find($request->get('user_id'));
        $friend = $me->friend($user);

        if (! $friend || $friend->pivot->status !== 'request') {
            throw new ApiException(trans('friends.no-request'));
        }

        Friend::accept($user);

        return api_response();
    }

    /**
     * Refuse friend
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws ApiException
     */
    public function refuse(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        /** @var User $me */
        $me = auth()->user();
        $user = User::find($request->get('user_id'));
        $friend = $me->friend($user);

        if (! $friend || $friend->pivot->status !== 'request') {
            throw new ApiException(trans('friends.no-request'));
        }

        Friend::refuse($user);

        return api_response();
    }

    /**
     * Remove friend
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws ApiException
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id'
        ]);

        /** @var User $me */
        $me = auth()->user();
        $user = User::find($request->get('user_id'));
        $friend = $me->friend($user);

        if (! $friend) {
            throw new ApiException(trans('friends.not-friends'));
        }

        Friend::remove($user);

        return api_response();
    }

    /**
     * Friends Search
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required',
        ]);

        $keyword = $request->get('keyword');

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

        return api_response([
            'friends' => $friends->map(function ($user) { return $user->getShortData(); }),
        ]);
    }
}
