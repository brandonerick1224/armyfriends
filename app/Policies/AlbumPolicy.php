<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    use HandlesAuthorization;

    /**
     * If user can edit
     *
     * @param  User  $user
     * @param  Album  $album
     * @return bool
     */
    public function update(User $user, Album $album)
    {
        return $user->id === $album->user_id && $album->type !== 'profile';
    }

    /**
     * If user can remove
     *
     * @param  User  $user
     * @param  Album  $album
     * @return bool
     */
    public function remove(User $user, Album $album)
    {
        return $user->id === $album->user_id && $album->type !== 'profile';
    }

    /**
     * If user can upload images
     *
     * @param  User  $user
     * @param  Album  $album
     * @return bool
     */
    public function upload(User $user, Album $album)
    {
        return $user->id === $album->user_id;
    }

}
