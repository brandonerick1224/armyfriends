<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class GuestsController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $guests = $user->profile->views()->orderBy('updated_at', 'desc')->take(30)->get();

        return view('guests.index', ['user' => $user, 'guests' => $guests]);
    }
}
