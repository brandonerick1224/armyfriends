<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        $posts = $user->profile_posts()->orderBy('created_at', 'desc')->take(20)->get();

        return view('home.index', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
