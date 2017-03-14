<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Index page
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        /** @var User $me */
        $me = auth()->user();

        if ($user->id === $me->id) {
            return redirect('/home');
        }

        $user->profile->view(); // View profile record

        return view('profile.index', [
            'user'   => $user,
            'posts'  => $user->profile_posts()->orderBy('created_at', 'desc')->take(20)->get(),
            'friend' => $me->friend($user),
        ]);
    }
}
