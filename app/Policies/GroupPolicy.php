<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * If user can edit
     *
     * @param  User  $user
     * @param  Group $group
     * @return bool
     */
    public function update(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }

    /**
     * If user can remove
     *
     * @param  User  $user
     * @param  Group $group
     * @return bool
     */
    public function remove(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }

    /**
     * If user can add posts
     *
     * @param  User  $user
     * @param  Group $group
     * @return bool
     */
    public function addPosts(User $user, Group $group)
    {
        return $group->inGroup($user);
    }

    /**
     * If user can remove posts
     *
     * @param  User  $user
     * @param  Group $group
     * @return bool
     */
    public function removePosts(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }

    /**
     * If user can add group users
     *
     * @param User  $user
     * @param Group $group
     * @return bool
     */
    public function addUsers(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }

    /**
     * If user can edit group users
     *
     * @param User  $user
     * @param Group $group
     * @return bool
     */
    public function editUsers(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }

    /**
     * If user can remove group users
     *
     * @param User  $user
     * @param Group $group
     * @return bool
     */
    public function removeUsers(User $user, Group $group)
    {
        return $group->isAdmin($user);
    }
}
