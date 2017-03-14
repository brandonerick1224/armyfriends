<?php

namespace App\Policies;

use App\Models\AlbumItem;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTagPolicy
{
    use HandlesAuthorization;

    /**
     * Can untag users
     *
     * @param User    $user
     * @param UserTag $userTag
     * @return bool
     */
    public function untag(User $user, UserTag $userTag)
    {
        if ($userTag->media->model->album->user_id ===  $user->id) {
            return true;
        }

        return $user->id === $userTag->user_id;
    }
}
