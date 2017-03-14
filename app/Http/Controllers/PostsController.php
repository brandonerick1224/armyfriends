<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * View single post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Post $post)
    {
        return view('posts.view', ['post' => $post]);
    }

    /**
     * Store post
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $this->validate($request, [
            'content' => 'required|max:1023',
            'image'   => 'image|image_size:300-3000,300-3000',
        ]);

        $group = Group::find($request->get('group_id'));
        if ($group) {
            $this->authorize('add-posts', $group);
        }

        $post = $me->posts()->create($request->only('content', 'group_id'));

        if ($request->hasFile('image')) {
            $post->addMedia($request->file('image'))->toCollection();
        }

        return redirect()->back()->with('success', trans('posts.post-created'));
    }

    /**
     * Edit post
     *
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Post $post)
    {
        session(['redirect' => \URL::previous()]);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update post
     *
     * @param Request $request
     * @param Post    $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize($post);

        $this->validate($request, [
            'content' => 'required|max:1023',
            'image'   => 'image|image_size:300-3000,300-3000',
        ]);

        $post->update($request->only(['content']));

        if ($request->get('remove_image') === 'true') {
            $post->clearMediaCollection();
        }

        if ($request->hasFile('image')) {
            $post->clearMediaCollection();
            $post->addMedia($request->file('image'))->toCollection();
        }

        return redirect(session('redirect', \URL::previous()))->with('success', trans('posts.post-updated'));
    }

    /**
     * Delete post
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Post $post)
    {
        $this->authorize($post);

        $post->delete();

        return redirect()->back()->with('success', trans('posts.post-deleted'));
    }
}
