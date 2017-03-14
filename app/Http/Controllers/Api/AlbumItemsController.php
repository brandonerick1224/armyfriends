<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEvent;
use App\Exceptions\ApiException;
use App\Http\Requests;
use App\Models\Album;
use App\Models\AlbumItem;
use App\Models\Media;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Http\Request;

class AlbumItemsController extends Controller
{
    /**
     * Show album items list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function items(Request $request)
    {
        $this->validate($request, [
            'album_id' => 'required|integer|exists:albums,id',
        ]);

        $album = Album::find($request->get('album_id'));

        return api_response([
            'album_items' => $album->items->map(function (AlbumItem $item) {
                return $item->getListData();
            }),
        ]);
    }

    /**
     * Show album item
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'album_item_id' => 'required|integer|exists:album_items,id',
        ]);

        $item = AlbumItem::find($request->get('album_item_id'));

        return api_response([
            'album_item' => $item->getPublicData(),
        ]);
    }

    /**
     * Upload
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'album_id' => 'required|integer|exists:albums,id',
            'title'    => 'min:3|max:255',
            'file'     => 'required|image|image_size:300-3000,300-3000',
        ]);

        $album = Album::find($request->get('album_id'));
        $this->authorize($album);
        
        /** @var AlbumItem $item */
        $item = $album->items()->create($request->only('title'));

        $item->addMedia($request->file('file'))->toCollection();

        return api_response();
    }

    /**
     * Update album item
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'album_item_id' => 'required|integer|exists:album_items,id',
            'title'         => 'min:3|max:255',
        ]);

        $albumItem = AlbumItem::find($request->get('album_item_id'));
        $this->authorize($albumItem);

        $albumItem->update($request->only('title'));

        return api_response(['album_item' => $albumItem->getListData()]);
    }

    /**
     * Remove album item
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'album_item_id' => 'required|integer|exists:album_items,id',
        ]);

        $albumItem = AlbumItem::find($request->get('album_item_id'));
        $this->authorize($albumItem);

        $albumItem->delete();

        return api_response();
    }

    /**
     * Set item image as profile
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function asProfile(Request $request)
    {
        $this->validate($request, [
            'album_item_id' => 'required|integer|exists:album_items,id',
        ]);

        /** @var User $me */
        $me = auth()->user();

        $albumItem = AlbumItem::find($request->get('album_item_id'));
        if ($albumItem->album->type !== 'profile') {
            throw new ApiException(trans('albums.only-profile-album-item'));
        }
        $this->authorize($albumItem);
        $me->setPictureAsProfile($albumItem->getFirstMedia());

        return api_response();
    }

    /**
     * Tag user to item
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function tag(Request $request)
    {
        $this->validate($request, [
            'album_item_id' => 'required|integer|exists:album_items,id',
            'user_id'       => 'required|exists:users,id',
            'x'             => 'required|numeric|between:0,1',
            'y'             => 'required|numeric|between:0,1',
        ]);

        /** @var User $me */
        $me = auth()->user();

        $albumItem = AlbumItem::find($request->get('album_item_id'));
        $this->authorizeForUser($me, $albumItem);
        $userId = $request->get('user_id');

        /** @var User $user */
        $user = $me->friends()->where('users.id', $userId)->first();
        if (! $user) {
            if ($me->id == $userId) {
                $user = $me;
            } else {
                throw new ApiException('You can tag only your friends or yourself!');
            }
        }

        /** @var Media $itemMedia */
        $itemMedia = $albumItem->getFirstMedia();
        if (! $itemMedia) {
            abort(500, 'No media for item.');
        }
        /** @var UserTag $userTag */
        $userTag = $itemMedia->user_tags()->create($request->only('user_id', 'x', 'y'));

        // Send notification to user, if it's not me
        if (! $user->isMe()) {
            event(new NotificationEvent($userTag, $user));
        }

        return api_response(['user_tag' => $userTag->getListData()]);
    }

    /**
     * Untag user from item
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws \Exception
     */
    public function untag(Request $request)
    {
        $this->validate($request, [
            'user_tag_id' => 'required|integer|exists:user_tags,id',
        ]);

        $userTag = UserTag::find($request->get('user_tag_id'));
        $this->authorize($userTag);

        $userTag->delete();

        return api_response();
    }
}
