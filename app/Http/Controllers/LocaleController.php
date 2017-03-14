<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Index page
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
        $this->validate($request, [
            'locale' => 'required|in:' . implode(',', array_keys(config('laravellocalization.supportedLocales'))),
        ]);

        return redirect()->back()->withCookie(\Cookie::forever('lang', $request->get('locale')));
    }
}
