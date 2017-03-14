<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\AlbumItem;
use App\Models\Post;
use App\Models\Traits\Likeable;
use App\Models\UserProfile;

class LikesController extends Controller
{
    /**
     * Likeable types
     *
     * @var array
     */
    protected static $types = [
        'user_profiles' => UserProfile::class,
        'posts'         => Post::class,
        'album_items'   => AlbumItem::class,
    ];

    /**
     * Like item
     *
     * @param         $type
     * @param         $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function like($type, $id)
    {
        if (! isset(self::$types[$type])) {
            return redirect()->back()->withErrors('Wrong type!');
        }

        /** @var Likeable $model */
        $model = with(new self::$types[$type])->find($id);

        if (! $model) {
            return redirect()->back()->withErrors('Wrong ID!');
        }

        $model->like();

        return redirect()->back();
    }

    /**
     * Unlike item
     *
     * @param         $type
     * @param         $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function unlike($type, $id)
    {
        if (! isset(self::$types[$type])) {
            return redirect()->back()->withErrors('Wrong type!');
        }

        /** @var Likeable $model */
        $model = with(new self::$types[$type])->find($id);

        if (! $model) {
            return redirect()->back()->withErrors('Wrong ID!');
        }

        $model->unlike();

        return redirect()->back();
    }

    /**
     * Show users that liked an item
     *
     * @param $type
     * @param $id
     * @return $this
     */
    public function likes($type, $id)
    {
        if (! isset(self::$types[$type])) {
            return redirect()->back()->withErrors('Wrong type!');
        }

        /** @var Likeable $model */
        $model = with(new self::$types[$type])->find($id);

        if (! $model) {
            return redirect()->back()->withErrors('Wrong ID!');
        }

        return view('likes.likes', [
            'model' => $model
        ]);
    }
}
