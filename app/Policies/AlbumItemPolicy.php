<?php

namespace App\Policies;

use App\Models\AlbumItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumItemPolicy
{
    use HandlesAuthorization;

    /**
     * If user can edit
     *
     * @param  User      $user
     * @param  AlbumItem $albumItem
     * @return bool
     */
    public function update(User $user, AlbumItem $albumItem)
    {
        return $user->id === $albumItem->album->user_id;
    }

    /**
     * If user can remove
     *
     * @param  User      $user
     * @param  AlbumItem $albumItem
     * @return bool
     */
    public function remove(User $user, AlbumItem $albumItem)
    {
        return $user->id === $albumItem->album->user_id
               // And picture is not set as profile picture
               && $user->picture_media_id !== $albumItem->getFirstMedia()->id;
    }

    /**
     * Can tag users
     *
     * @param User      $user
     * @param AlbumItem $albumItem
     * @return bool
     */
    public function tag(User $user, AlbumItem $albumItem)
    {
        return $user->id === $albumItem->album->user_id;
    }

    /**
     * If user can set item as profile image
     *
     * @param User      $user
     * @param AlbumItem $albumItem
     * @return bool
     */
    public function asProfile(User $user, AlbumItem $albumItem)
    {
        return $user->id === $albumItem->album->user_id // User is owner
               && $albumItem->album->type === 'profile' // Album type is profile
               && $albumItem->getFirstMedia()->id !== $user->picture_media_id; // Is not set already
    }
}
