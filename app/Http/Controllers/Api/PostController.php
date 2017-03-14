<?php

namespace App\Http\Controllers\Api;

use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get posts list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function posts(Request $request)
    {
        $this->validate($request, [
            'user_id'  => 'required_without:group_id|integer|exists:users,id',
            'group_id' => 'required_without:user_id|integer|exists:groups,id',
            'offset'   => 'ingeter|min:0',
        ]);

        $user = User::find($request->get('user_id'));
        $group = Group::find($request->get('group_id'));

        if ($user) {
            $posts = $user->profile_posts()->orderBy('created_at', 'desc')
                ->take(30)->skip($request->get('offset', 0))->get();
        } else {
            $posts = $group->posts()->orderBy('created_at', 'desc')
                ->take(30)->skip($request->get('offset', 0))->get();
        }

        return api_response([
            'posts' => $posts->map(function (Post $post) {
                return $post->getListData();
            }),
        ]);
    }

    /**
     * Show post
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function show(Request $request)
    {
        $this->validate($request, [
            'post_id'  => 'required|integer|exists:posts,id',
        ]);

        $post = Post::find($request->get('post_id'));

        return api_response(['post' => $post->getPublicData()]);
    }

    /**
     * Create post
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'content'  => 'required|max:1023',
            'image'    => 'image|image_size:300-3000,300-3000',
            'group_id' => 'integer|exists:groups,id',
        ]);

        /** @var User $me */
        $me = auth()->user();
        
        $group = Group::find($request->get('group_id'));
        if ($group) {
            $this->authorize('add-posts', $group);
        }

        $data = $request->only('content', 'group_id');
        if (! $data['group_id']) {
            unset($data['group_id']);
        }
        /** @var Post $post */
        $post = $me->posts()->create($data);

        if ($request->hasFile('image')) {
            $post->addMedia($request->file('image'))->toCollection();
        }
        
        return api_response(['post' => $post->getPublicData()]);
    }

    /**
     * Update post
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'post_id'  => 'required|integer|exists:posts,id',
            'content'  => 'max:1023',
            'image'    => 'image|image_size:300-3000,300-3000',
        ]);

        $post = Post::find($request->get('post_id'));

        $this->authorize($post);

        if ($request->get('content')) {
            $post->content = $request->get('content');
        }

        $post->save();

        if ($request->get('remove_image') === 'true') {
            $post->clearMediaCollection();
        }

        if ($request->hasFile('image')) {
            $post->clearMediaCollection();
            $post->addMedia($request->file('image'))->toCollection();
        }

        return api_response(['post' => $post->getPublicData()]);
    }

    /**
     * Remove post
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'post_id'  => 'required|integer|exists:posts,id',
        ]);

        $post = Post::find($request->get('post_id'));

        $this->authorize($post);

        $post->delete();

        return api_response();
    }
}
