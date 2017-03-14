<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    /**
     * Index page
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        return view('albums.index', [
            'user'   => $user,
            'albums' => $user->albums,
        ]);
    }

    /**
     * Show album
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Album $album)
    {
        return view('albums.view', [
            'user'        => $album->user,
            'album'       => $album,
            'albums'      => $album->user->albums,
            'album_items' => $album->items,
        ]);
    }

    /**
     * Create new album
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        /** @var User $me */
        $me = auth()->user();

        return view('albums.create', ['albums' => $me->albums]);
    }

    /**
     * Store album
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
        ]);

        /** @var User $me */
        $me = auth()->user();

        $album = $me->albums()->create($request->only(['title']));

        return redirect('albums/view/' . $album->id)->with('success', trans('albums.album-created'));
    }

    /**
     * Edit album
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Album $album)
    {
        return view('albums.edit', [
            'album'       => $album,
            'albums'      => $album->user->albums,
        ]);
    }

    /**
     * Update album
     *
     * @param Request $request
     * @param Album   $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Album $album)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
        ]);

        $this->authorize($album);

        $album->update($request->only('title'));

        return redirect()->back()->with('success', trans('albums.album-updated'));
    }

    /**
     * Remove album
     *
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Album $album)
    {
        $this->authorize($album);

        $album->delete();

        return redirect('albums')->with('success', trans('albums.album-removed'));
    }

    /**
     * Upload images for album
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function upload(Album $album)
    {
        return view('albums.upload', [
            'album'  => $album,
            'albums' => $album->user->albums,
        ]);
    }
}
