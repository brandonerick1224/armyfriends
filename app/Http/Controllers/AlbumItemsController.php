<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumItem;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumItemsController extends Controller
{
    /**
     * View image
     *
     * @param AlbumItem $albumItem
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(AlbumItem $albumItem)
    {
        return view('album_items.view', [
            'item'   => $albumItem,
            'albums' => $albumItem->album->user->albums,
        ]);
    }

    /**
     * Upload gallery item
     *
     * @param Request $request
     * @param Album   $album
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, Album $album)
    {
        $validator = \Validator::make($request->all(), [
            'file' => 'required|image|image_size:300-3000,300-3000',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->get('file')[0], 422);
        }

        $this->authorize($album);

        /** @var AlbumItem $item */
        $item = $album->items()->create([]);

        $item->addMedia($request->file('file'))->toCollection();

        return 'Ok';
    }

    /**
     * Update album item
     *
     * @param Request   $request
     * @param AlbumItem $albumItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AlbumItem $albumItem)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
        ]);

        $this->authorize($albumItem);

        $albumItem->update($request->only(['title']));

        return redirect()->back()->with('success', trans('albums.image-updated'));
    }

    /**
     * Remove album item
     *
     * @param AlbumItem $albumItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(AlbumItem $albumItem)
    {
        $this->authorize($albumItem);

        $redirect = 'albums/view/' . $albumItem->album_id;

        $albumItem->delete();

        return redirect($redirect)->with('success', trans('albums.image-removed'));
    }

    /**
     * Set item as profile picture
     *
     * @param AlbumItem $albumItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asProfile(AlbumItem $albumItem)
    {
        $this->authorize($albumItem);

        /** @var User $me */
        $me = auth()->user();
        $me->setPictureAsProfile($albumItem->getFirstMedia());

        return redirect()->back()->with('success', trans('albums.image-set-as-profile'));
    }
}
