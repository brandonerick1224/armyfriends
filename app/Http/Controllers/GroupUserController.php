<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\GroupUser;
use Illuminate\Http\Request;

class GroupUserController extends Controller
{
    /**
     * Approve join request
     *
     * @param GroupUser $groupUser
     * @return mixed
     */
    public function approve(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        switch ($groupUser->status) {
            case 'accept':
                return redirect()->back()->withErrors('User already joined the group!');
            case 'invite':
                return redirect()->back()->withErrors('Invite is sent to this user!');
        }

        $groupUser->update(['status' => 'accept']);
        event(new NotificationEvent($groupUser, $groupUser->user));

        return redirect()->back()->with('success', trans('groups.user-approved'));
    }

    /**
     * Decline join request or invite
     *
     * @param GroupUser $groupUser
     * @return mixed
     */
    public function decline(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        switch ($groupUser->status) {
            case 'accept':
                return redirect()->back()->withErrors('User already joined the group!');
            case 'invite':
                return redirect()->back()->withErrors('Invite is sent to this user!');
        }

        $groupUser->delete();

        return redirect()->back()->with('success', trans('groups.user-declined'));
    }

    /**
     * Cancel invitation
     *
     * @param GroupUser $groupUser
     * @return mixed
     */
    public function cancel(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        if ($groupUser->status !== 'invite') {
            return redirect()->back()->withErrors(trans('groups.no-invitation-user'));
        }

        $groupUser->delete();

        return redirect()->back()->with('success', trans('groups.invitation-canceled'));
    }

    /**
     * Accept invite
     *
     * @param GroupUser $groupUser
     * @return mixed
     */
    public function accept(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        if ($groupUser->status === 'accept') {
            return redirect()->back()->withErrors(trans('groups.already-joined'));
        }

        $groupUser->update(['status' => 'accept']);
        $groupUser->group->notifyAdmins($groupUser);

        return redirect()->back()->with('success', trans('groups.you-accepted'));
    }

    /**
     * Refuse join the group
     *
     * @param GroupUser $groupUser
     * @return mixed
     */
    public function refuse(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        if ($groupUser->status !== 'invite') {
            return redirect()->back()->withErrors(trans('groups.no-invitation'));
        }

        $groupUser->delete();

        return redirect()->back()->with('success', trans('groups.you-refused'));
    }

    /**
     * Edit group user
     *
     * @param GroupUser $groupUser
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(GroupUser $groupUser)
    {
        $this->authorize('update');

        return view('group_user.edit', ['groupUser' => $groupUser]);
    }

    /**
     * Update group user
     *
     * @param Request   $request
     * @param GroupUser $groupUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        $this->validate($request, [
            'type' => 'required|in:participant,admin',
        ]);

        $groupUser->update($request->only('type'));

        return redirect()->back()->with('success', trans('groups.user-updated'));
    }

    /**
     * Remove user from group
     *
     * @param GroupUser $groupUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(GroupUser $groupUser)
    {
        $this->authorize($groupUser);

        if ($groupUser->type === 'admin') {
            return redirect()->back()->withErrors(trans('groups.cant-remove-admin'));
        }

        $groupUser->delete();

        return redirect()->back()->with('success', trans('groups.user-removed'));
    }
}
