<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEvent;
use App\Exceptions\ApiException;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    /**
     * Approve join request
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function approve(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        switch ($groupUser->status) {
            case 'accept':
                throw new ApiException(trans('groups.user-already-in'));
            case 'invite':
                throw new ApiException(trans('groups.invite-sent-to-user'));
        }

        $groupUser->update(['status' => 'accept']);
        event(new NotificationEvent($groupUser, $groupUser->user));

        return api_response();
    }

    /**
     * Decline join request
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function decline(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        switch ($groupUser->status) {
            case 'accept':
                throw new ApiException(trans('groups.user-already-in'));
            case 'invite':
                throw new ApiException(trans('groups.invite-sent-to-user'));
        }

        $groupUser->delete();

        return api_response();
    }

    /**
     * Cancel invitation
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function cancel(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        if ($groupUser->status !== 'invite') {
            throw new ApiException(trans('groups.no-invitation-user'));
        }

        $groupUser->delete();

        return api_response();
    }

    /**
     * Accept invitation
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function accept(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        $groupUser->update(['status' => 'accept']);
        $groupUser->group->notifyAdmins($groupUser);

        return api_response();
    }

    /**
     * Refuse invitation
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function refuse(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        if ($groupUser->status !== 'invite') {
            throw new ApiException(trans('groups.no-invitation'));
        }

        $groupUser->delete();

        return api_response();
    }

    /**
     * Update group user
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
            'type'          => 'required|in:participant,admin',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        if ($request->get('type') === 'participant' && $groupUser->group->admins()->count() < 2) {
            throw new ApiException(trans('groups.cant-remove-last-admin'));
        }

        $groupUser->update($request->only('type'));

        return api_response(['group_user' => $groupUser->getListData()]);
    }

    /**
     * Remove group user
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'group_user_id' => 'required|integer|exists:group_user,id',
        ]);

        $groupUser = GroupUser::find($request->get('group_user_id'));
        $this->authorize($groupUser);

        if ($groupUser->type === 'admin') {
            throw new ApiException(trans('groups.cant-remove-admin'));
        }

        $groupUser->delete();

        return api_response();
    }
}
