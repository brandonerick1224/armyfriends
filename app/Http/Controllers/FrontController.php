<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class FrontController extends Controller
{
    /**
     * Show front page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect('home');
        }

        return view('front.front');
    }
}
