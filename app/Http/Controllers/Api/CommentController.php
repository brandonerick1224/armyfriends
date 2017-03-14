<?php

namespace App\Http\Controllers\Api;

use App\Events\CommentEvent;
use App\Models\Comment;
use App\Models\Traits\Commentable;
use App\Models\Traits\Subscribable;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get comments list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function comments(Request $request)
    {
        $commentables = config('morphs.commentable');
        $this->validate($request, [
            'commentable_type' => 'required|in:'.implode(',', array_keys($commentables)),
            'commentable_id'   => 'required|integer|min:0',
            'offset'           => 'integer|min:0',
        ]);

        /** @var Commentable|Subscribable $model */
        $commentable = with(new $commentables[$request->get('commentable_type')])
            ->find($request->get('commentable_id'));


        return api_response(['comments' => $commentable->comments()->orderBy('created_at', 'desc')
            ->take(30)->skip($request->get('offset'))->get()->map(function (Comment $comment) {
                return $comment->getListData(false);
            })]);
    }

    /**
     * Create comment
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function create(Request $request)
    {
        $commentables = config('morphs.commentable');
        $this->validate($request, [
            'commentable_type' => 'required|in:'.implode(',', array_keys($commentables)),
            'commentable_id'   => 'required|integer|min:0',
            'content' => 'required|max:1023',
        ]);

        /** @var Commentable|Subscribable $model */
        $commentable = with(new $commentables[$request->get('commentable_type')])
            ->find($request->get('commentable_id'));

        /** @var Comment $comment */
        $comment = $commentable->comment($request->get('content'));

        $commentable->subscribe(); // Subscribe user for the object

        return api_response(['comment' => $comment->getListData()]);
    }

    /**
     * Update comment
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'comment_id' => 'required|integer|exists:comments,id',
            'content'    => 'required|max:1023',
        ]);

        $comment = Comment::find($request->get('comment_id'));
        $this->authorize($comment);

        $comment->update($request->only('content'));

        event(new CommentEvent($comment, 'update'));

        return api_response(['comment' => $comment->getListData()]);
    }

    /**
     * Remove comment
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function remove(Request $request)
    {
        $this->validate($request, [
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        $comment = Comment::find($request->get('comment_id'));
        $this->authorize($comment);

        event(new CommentEvent($comment, 'remove'));

        $comment->delete();

        return api_response();
    }
}
