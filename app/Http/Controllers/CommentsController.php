<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Http\Requests;
use App\Models\AlbumItem;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Traits\Commentable;
use App\Models\Traits\Subscribable;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Commentable types
     *
     * @var array
     */
    protected static $types = [
        'posts'       => Post::class,
        'album_items' => AlbumItem::class,
    ];

    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $me = auth()->user();

        $comments = $me->comments()
            ->groupBy(\DB::raw('concat(commentable_type,commentable_id)'))
            ->orderBy('created_at', 'desc')->take('20')->get();

        // To fix last comment instead of first: @see http://stackoverflow.com/a/1313293/1753349

        return view('comments.index', [
            'user'     => $me,
            'comments' => $comments,
        ]);
    }

    /**
     * Load more comments
     *
     * @param $type
     * @param $objectId
     * @param $lastId
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function load($type, $objectId, $lastId)
    {
        if (! isset(self::$types[$type])) {
            return redirect()->back()->withErrors('Wrong type!');
        }

        /** @var Commentable|Subscribable $model */
        $model = with(new self::$types[$type])->find($objectId);

        if (! $model) {
            return redirect()->back()->withErrors('Wrong ID!');
        }

        $comments = $model->getVueComments($lastId);

        return response()->json(['result' => 'Ok', 'comments' => $comments]);
    }
    
    /**
     * Comment item
     *
     * @param Request $request
     * @param         $type
     * @param         $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function add(Request $request, $type, $id)
    {
        $this->validate($request, [
            'content' => 'required|max:1023',
        ]);

        if (! isset(self::$types[$type])) {
            return redirect()->back()->withErrors('Wrong type!');
        }

        /** @var Commentable|Subscribable $model */
        $model = with(new self::$types[$type])->find($id);

        if (! $model) {
            return redirect()->back()->withErrors('Wrong ID!');
        }

        $comment = $model->comment($request->get('content'));

        $model->subscribe(); // Subscribe user for the object

        if ($request->ajax()) {
            return response()->json(['result' => 'Ok', 'comment' => $comment->getData()]);
        }

        return redirect()->back()->with('success', trans('comments.comment-added'));
    }

    /**
     * Update comment
     *
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request, [
            'content' => 'required|max:1023',
        ]);

        $this->authorize($comment);

        $comment->update($request->only('content'));

        event(new CommentEvent($comment, 'update'));

        return response()->json(['result' => 'Ok']);
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Comment $comment)
    {
        $this->authorize($comment);

        event(new CommentEvent($comment, 'remove'));

        $comment->delete();

        return response()->json(['result' => 'Ok']);
    }
}
