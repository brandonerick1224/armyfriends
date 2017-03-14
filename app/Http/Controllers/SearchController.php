<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->only(['name', 'first_name', 'last_name', 'start_date', 'end_date', 'city', 'country']);
        if (! array_filter($input)) {
            return view('search.search', ['profiles' => []]);
        }

        $data = array_filter([
            'name'               => $input['name'],
            'first_name'         => $input['first_name'],
            'last_name'          => $input['last_name'],
            'service_city'       => $input['city'],
            'service_country_id' => $input['country'],
        ]);

        $profile = UserProfile::where($data);
        $profile->join('users', 'users.id', '=', 'user_profiles.user_id')->with('user');

        if ($input['start_date']) {
            $profile->where('service_start_date', '>=', Carbon::parse($input['start_date'])->toDateString());
        }
        if ($input['end_date']) {
            $profile->where('service_end_date', '<=', Carbon::parse($input['end_date'])->toDateString());
        }

        $profiles = $profile->get();

        return view('search.search', ['profiles' => $profiles]);
    }
}
