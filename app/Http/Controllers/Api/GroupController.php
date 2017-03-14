<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEvent;
use App\Exceptions\ApiException;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * My groups
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function my()
    {
        /** @var User $me */
        $me = auth()->user();

        return api_response([
            'groups' => $me->groups->map(function (Group $group) {
                return $group->getListData();
            }),
            'invites' => $me->groups_invites->map(function (Group $group) {
                return $group->getListData();
            }),
            'requests' => $me->groups_requests->map(function (Group $group) {
                return $group->getListData();
            }),
        ]);
    }
    
    /**
     * Search group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => 'required',
        ]);

        $query = $request->get('query');

        $groups = Group::where('title', 'like', "%$query%")->take(30)->get();

        return api_response(['groups' => $groups->map(function (Group $group) {
            return $group->getListData();
        })]);
    }

    /**
     * Show group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $group = Group::find($request->get('group_id'));

        return api_response(['group' => $group->isAdmin() ? $group->getFullData() : $group->getPublicData()]);
    }

    /**
     * Create group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title'       => 'required|min:5|max:255',
            'description' => 'min:5|max:1023',
            'type'        => 'required|in:public,private',
            'image'       => 'required|image|image_size:300-4000,300-4000',
        ]);

        /** @var User $me */
        $me = auth()->user();

        // Create group
        $group = Group::create($request->only('title', 'description', 'type'));
        // Save cover image
        $group->addMedia($request->file('image'))->toCollection('cover');
        // Attach to user with admin rights
        $me->groups()->attach($group, ['type' => 'admin', 'status' => 'accept']);

        return api_response(['group' => $group->getPublicData()]);
    }

    /**
     * Update group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'group_id'    => 'required|integer|exists:groups,id',
            'title'       => 'required|min:5|max:255',
            'description' => 'min:5|max:1023',
            'type'        => 'required|in:public,private',
            'image'       => 'image|image_size:300-4000,300-4000',
        ]);

        $group = Group::find($request->get('group_id'));
        $this->authorize($group);

        $group->update($request->only('title', 'description', 'type'));

        if ($request->file('image')) {
            $group->clearMediaCollection('cover');
            $group->addMedia($request->file('image'))->toCollection('cover');
        }

        return api_response(['group' => $group->getPublicData()]);
    }

    /**
     * Remove group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        $group = Group::find($request->get('group_id'));
        $this->authorize($group);

        $group->delete();

        return api_response();
    }

    /**
     * Join group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function join(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        /** @var User $me */
        $me = auth()->user();
        $group = Group::find($request->get('group_id'));
        $groupUser = $group->groupUser($me);

        if ($groupUser) {
            switch ($groupUser->status) {
                case 'request':
                    throw new ApiException(trans('groups.already-sent-request'));
                case 'accept':
                    throw new ApiException(trans('groups.already-joined'));
                case 'invite':
                    $groupUser->update(['status' => 'accept']);
                    $group->notifyAdmins($groupUser);

                    return api_response();
            }
        }

        if ($group->type === 'private') {
            $groupUser = GroupUser::create([
                'user_id'  => $me->id,
                'group_id' => $group->id,
                'status'   => 'request'
            ]);
            $group->notifyAdmins($groupUser);

            return api_response(['success' => trans('groups.you-sent-request')]);
        }

        $groupUser = GroupUser::create([
            'user_id'  => $me->id,
            'group_id' => $group->id,
        ]);
        $group->notifyAdmins($groupUser);

        return api_response();
    }

    /**
     * Leave group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function leave(Request $request)
    {
        $this->validate($request, [
            'group_id' => 'required|integer|exists:groups,id',
        ]);

        /** @var User $me */
        $me = auth()->user();
        $group = Group::find($request->get('group_id'));
        $groupUser = $group->groupUser($me);

        if (! $groupUser) {
            throw new ApiException(trans('groups.not-joined'));
        }

        if ($groupUser->type === 'admin' && $group->admins->count() === 1) {
            throw new ApiException(trans('groups.last-admin'));
        }

        $groupUser->delete();

        return api_response();
    }

    /**
     * Invite to group
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function invite(Request $request)
    {
        $this->validate($request, [
            'group_id'  => 'required|integer|exists:groups,id',
            'users_ids' => 'required',
        ]);

        $group = Group::find($request->get('group_id'));
        if ($group->type === 'private') {
            $this->authorize('add-users', $group);
        }

        // Users ids, separated by comma
        $usersIds = array_filter(explode(',', $request->get('users_ids')));

        foreach ($usersIds as $userId) {
            // Skip non-existent users
            if (! User::find((int) $userId)) {
                continue;
            }

            // Skip users that already linked to group
            if (GroupUser::where([
                'user_id'  => $userId,
                'group_id' => $group->id,
            ])->exists()) {
                continue;
            }

            $groupUser = GroupUser::create([
                'user_id'  => $userId,
                'group_id' => $group->id,
                'status'   => 'invite',
            ]);

            event(new NotificationEvent($groupUser, $groupUser->user));
        }

        return api_response();
    }
}
