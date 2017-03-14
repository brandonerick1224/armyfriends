<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $me */
        $me = auth()->user();

        return view('groups.index', [
            'user'   => $me,
            'groups' => $me->groups,
        ]);
    }

    /**
     * Search page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        if (empty($query)) {
            return redirect()->back();
        }

        $groups = Group::where('title', 'like', "%$query%")->take(30)->get();

        return view('groups.search', ['groups' => $groups]);
    }

    /**
     * View group
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Group $group)
    {
        /** @var User $me */
        $me = auth()->user();

        $posts = $group->posts()->orderBy('created_at', 'desc')->take(30)->get();

        return view('groups.view', [
            'group'     => $group,
            'posts'     => $posts,
            'groupUser' => $group->groupUser($me),
        ]);
    }


    /**
     * Create group
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store group
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $this->validate($request, [
            'title'       => 'required|min:5|max:255',
            'description' => 'min:5|max:1023',
            'type'        => 'required|in:public,private',
            'image'       => 'required|image|image_size:300-4000,300-4000',
        ]);

        // Create group
        $group = Group::create($request->only('title', 'description', 'type'));
        // Save cover image
        $group->addMedia($request->file('image'))->toCollection('cover');
        // Attach to user with admin rights
        $me->groups()->attach($group, ['type' => 'admin', 'status' => 'accept']);

        return redirect('groups/view/' . $group->id)->with('success', trans('groups.group-created'));
    }

    /**
     * Edit group
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Group $group)
    {
        session(['redirect' => \URL::previous()]);

        return view('groups.edit', ['group' => $group]);
    }

    /**
     * Update group
     *
     * @param Request $request
     * @param Group    $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize($group);

        $this->validate($request, [
            'title'       => 'required|min:5|max:255',
            'description' => 'min:5|max:1023',
            'type'        => 'required|in:public,private',
            'image'       => 'image|image_size:300-4000,300-4000',
        ]);

        $group->update($request->only('title', 'description', 'type'));

        if ($request->file('image')) {
            $group->clearMediaCollection('cover');
            $group->addMedia($request->file('image'))->toCollection('cover');
        }

        return redirect(session('redirect', \URL::previous()))->with('success', trans('groups.group-updated'));
    }

    /**
     * Delete group
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Group $group)
    {
        $this->authorize($group);

        $group->delete();

        return redirect('groups')->with('success', trans('groups.group-deleted'));
    }

    /**
     * Join group
     *
     * @param Group $group
     * @return mixed
     */
    public function join(Group $group)
    {
        /** @var User $me */
        $me = auth()->user();

        $groupUser = $group->groupUser($me);

        if ($groupUser) {
            switch ($groupUser->status) {
                case 'request':
                    return redirect()->back()->withErrors('You already sent request!');
                case 'accept':
                    return redirect()->back()->withErrors('You already joined the group!');
                case 'invite':
                    $groupUser->update(['status' => 'accept']);
                    $group->notifyAdmins($groupUser);
                    return redirect()->back()->with('success', 'You joined the group!');
            }
        }

        if ($group->type === 'private') {
            $groupUser = GroupUser::create([
                'user_id'  => $me->id,
                'group_id' => $group->id,
                'status'   => 'request'
            ]);
            $group->notifyAdmins($groupUser);
            return redirect()->back()->with('success', trans('groups.you-sent-request'));
        }

        $groupUser = GroupUser::create([
            'user_id'  => $me->id,
            'group_id' => $group->id,
        ]);
        $group->notifyAdmins($groupUser);

        return redirect()->back()->with('success', trans('groups.you-joined'));
    }

    /**
     * Leave group
     *
     * @param Group $group
     * @return mixed
     */
    public function leave(Group $group)
    {
        /** @var User $me */
        $me = auth()->user();

        $groupUser = $group->groupUser($me);

        if (! $groupUser) {
            return redirect()->back()->withErrors('You are not joined the group!');
        }

        if ($groupUser->type === 'admin' && $group->admins->count() === 1) {
            return redirect()->back()->withErrors('You are the last administrator in the group,
            you can\'t leave group!');
        }

        $groupUser->delete();

        return redirect()->back()->with('success', trans('groups.you-left'));
    }


    /**
     * Invite users to a group
     *
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function invite(Group $group)
    {
        /** @var User $me */
        $me = auth()->user();

        return view('groups.invite', [
            'user'    => $me,
            'group'   => $group,
        ]);
    }

    /**
     * Invite to group
     *
     * @param Request $request
     * @param Group   $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postInvite(Request $request, Group $group)
    {
        if ($group->type === 'private') {
            $this->authorize('add-users', $group);
        }

        $this->validate($request, [
            'users'   => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        foreach ($request->get('users') as $userId) {
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

        return redirect()->back()->with('success', trans('groups.initation-sent'));
    }

}
