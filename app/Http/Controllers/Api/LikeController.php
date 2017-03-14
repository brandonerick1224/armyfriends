<?php

namespace App\Http\Controllers\Api;

use App\Models\Like;
use App\Models\Traits\Likeable;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Get likes list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function likes(Request $request)
    {
        $likeables = config('morphs.likeable');
        $this->validate($request, [
            'likeable_type' => 'required|in:'.implode(',', array_keys($likeables)),
            'likeable_id'   => 'required|integer|min:0',
            'offset'        => 'integer|min:0',
        ]);

        /** @var Likeable $likeable */
        $likeable = with(new $likeables[$request->get('likeable_type')])
            ->findOrFail($request->get('likeable_id'));

        return api_response(['likes' => $likeable->likes()->orderBy('created_at', 'desc')
            ->take(30)->skip($request->get('offset'))->get()->map(function (Like $like) {
                return $like->getListData(false);
            })]);
    }

    /**
     * Like
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function like(Request $request)
    {
        $likeables = config('morphs.likeable');
        $this->validate($request, [
            'likeable_type' => 'required|in:'.implode(',', array_keys($likeables)),
            'likeable_id'   => 'required|integer|min:0',
        ]);

        /** @var Likeable $likeable */
        $likeable = with(new $likeables[$request->get('likeable_type')])
            ->findOrFail($request->get('likeable_id'));

        $likeable->like();

        return api_response();
    }

    /**
     * Unlike
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function unlike(Request $request)
    {
        $likeables = config('morphs.likeable');
        $this->validate($request, [
            'likeable_type' => 'required|in:'.implode(',', array_keys($likeables)),
            'likeable_id'   => 'required|integer|min:0',
        ]);

        /** @var Likeable $likeable */
        $likeable = with(new $likeables[$request->get('likeable_type')])
            ->findOrFail($request->get('likeable_id'));

        $likeable->unlike();

        return api_response();
    }
}
