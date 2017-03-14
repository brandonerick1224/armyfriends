<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * If user can edit
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * If user can remove
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function remove(User $user, Post $post)
    {
        if ($post->user_id === $user->id) {
            return true;
        }

        if (Gate::allows('remove-posts', $post->group)) {
            return true;
        }

        return false;
    }
}
