<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** @var User $me */
        $me = auth()->user();

        return view('settings.index', ['user' => $me]);
    }

    /**
     * Update user profile
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var User $me */
        $me = auth()->user();

        $this->validate($request, [
            'password' => 'min:6|confirmed',

            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'country'    => 'required|max:255',
            'city'       => 'required|max:255',
            'birth_date' => 'required|date|max:255',

            'service_start_date' => 'required|date|max:255',
            'service_end_date'   => 'required|date|max:255',
            'service_country'    => 'required|max:255',
            'service_city'       => 'required|max:255',
            'about_me'           => 'max:1023',

            'image' => 'image|image_size:300-3000,300-3000',
        ]);

        $data = $request->all();

        // Update password if sent
        if ($data['password']) {
            $me->update(['password' => bcrypt($data['password'])]);
        }

        $me->update(['options' => $data['options']]);

        $me->profile->update([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'country_id' => $data['country'],
            'city'       => $data['city'],
            'birth_date' => Carbon::parse($data['birth_date']),

            'service_start_date' => Carbon::parse($data['service_start_date']),
            'service_end_date'   => Carbon::parse($data['service_end_date']),
            'service_country_id' => $data['service_country'],
            'service_city'       => $data['service_city'],
            'about_me'           => strip_tags($data['about_me']),
        ]);

        if (! empty($data['image'])) {
            $me->addProfilePicture($data['image']);
        }

        return redirect()->back()->with('success', trans('profile.profile-updated'));
    }
}
