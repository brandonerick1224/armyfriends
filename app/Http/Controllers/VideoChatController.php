<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class VideoChatController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        return view('video-chat.index', ['user' => $user]);
    }
}
