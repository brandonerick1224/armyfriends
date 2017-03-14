<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Albums list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function albums(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::find($request->get('user_id'));

        return api_response([
            'albums' => $user->albums->map(function (Album $album) {
                return $album->getListData();
            }),
        ]);
    }

    /**
     * Create album
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
        ]);

        /** @var User */
        $me = auth()->user();

        $album = $me->albums()->create($request->only(['title']));

        return api_response(['album' => $album->getListData()]);
    }

    /**
     * Update album
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'album_id' => 'required|integer|exists:albums,id',
            'title'    => 'required|min:3|max:255',
        ]);

        $album = Album::find($request->get('album_id'));

        $this->authorize($album);

        $album->update($request->only('title'));

        return api_response(['album' => $album->getListData()]);
    }

    /**
     * Remove album
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'album_id' => 'required|integer|exists:albums,id',
        ]);

        $album = Album::find($request->get('album_id'));

        $this->authorize($album);

        $album->delete();

        return api_response();
    }
}
