<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Models\Country;

class DocsController extends Controller
{
    /**
     * Show docs
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('+api.docs', [
            'countries' => Country::orderBy('name')->lists('name', 'id'),
        ]);
    }
}
