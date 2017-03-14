<?php

namespace App\Policies;

use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupUserPolicy
{
    use HandlesAuthorization;

    /**
     * If user can approve join request
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function approve(User $user, GroupUser $groupUser)
    {
        return $groupUser->group->isAdmin($user);
    }

    /**
     * If user can decline join request
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function decline(User $user, GroupUser $groupUser)
    {
        return $groupUser->group->isAdmin($user);
    }

    /**
     * If user can cancel invitation
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function cancel(User $user, GroupUser $groupUser)
    {
        return $groupUser->group->isAdmin($user);
    }

    /**
     * If user can accept invitation
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function accept(User $user, GroupUser $groupUser)
    {
        return $groupUser->user_id === $user->id;
    }

    /**
     * If user can refuse invitation
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function refuse(User $user, GroupUser $groupUser)
    {
        return $groupUser->user_id === $user->id;
    }

    /**
     * If user can update item
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function update(User $user, GroupUser $groupUser)
    {
        return $groupUser->group->isAdmin($user);
    }

    /**
     * If user can remove item
     *
     * @param  User  $user
     * @param  GroupUser $groupUser
     * @return bool
     */
    public function remove(User $user, GroupUser $groupUser)
    {
        return $groupUser->group->isAdmin($user);
    }
}
