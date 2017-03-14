<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * If user can edit
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * If user can remove
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function remove(User $user, Comment $comment)
    {
        $key = 'can-' . $user->id . '-remove-comment-' . $comment->id;
        return \Cache::remember($key, 24 * 30, function () use ($user, $comment) {

            if ($comment->user_id === $user->id) {
                return true;
            }

            if (\Gate::allows('update', $comment->commentable)) {
                return true;
            }

            return false;
        });
    }
}
