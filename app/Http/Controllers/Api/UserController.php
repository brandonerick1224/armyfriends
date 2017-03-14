<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Http\Requests;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\View;
use Auth;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class UserController extends Controller
{
    use ThrottlesLogins;

    /**
     * Get profile data
     *
     * @param array $data
     * @return array
     */
    protected function getProfileData($data)
    {
        return [
            'first_name' => array_get($data, 'first_name'),
            'last_name'  => array_get($data, 'last_name'),
            'country_id' => array_get($data, 'country'),
            'city'       => array_get($data, 'city'),
            'birth_date' => array_get($data, 'birth_date')
                ? Carbon::parse($data['birth_date']) : null,

            'service_start_date' => array_get($data, 'service_start_date')
                ? Carbon::parse($data['service_start_date']) : null,
            'service_end_date'   => array_get($data, 'service_end_date')
                ? Carbon::parse($data['service_end_date']) : null,
            'service_country_id' => array_get($data, 'service_country'),
            'service_city'       => array_get($data, 'service_city'),
            'about_me'           => strip_tags(array_get($data, 'about_me')),
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        \DB::beginTransaction();

        $user = User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => bcrypt($data['password']),
            'socket_token' => str_random(60),
            'api_token'    => str_random(60),
            'last_online'  => date('Y-m-d H:i:s'),
        ]);

        $profileData = $this->getProfileData($data);
        $profileData['user_id'] = $user->id;

        $profile = UserProfile::create($profileData);

        $user->addProfilePicture($data['image']);

        \DB::commit();

        return $user;
    }

    /**
     * Register user
     *
     * @param Request $request
     * @return array
     * @throws ApiException
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',

            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'country'    => 'required|exists:countries,id|max:255',
            'city'       => 'required|max:255',
            'birth_date' => 'required|date|max:255',

            'service_start_date' => 'required|date|max:255',
            'service_end_date'   => 'required|date|max:255',
            'service_country'    => 'required|exists:countries,id|max:255',
            'service_city'       => 'required|max:255',

            'image' => 'required|image|image_size:300-3000,300-3000',
        ]);

        $user = $this->create($request->all());

        $user->fresh();

        return api_response([
            'api_token'    => $user->api_token,
            'socket_token' => $user->socket_token,
            'user'         => $user->getFullData(),
        ]);
    }

    /**
     * Login user
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws AuthorizationException
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $seconds = app(RateLimiter::class)->availableIn($this->getThrottleKey($request));
            throw new TooManyRequestsHttpException($seconds, $this->getLockoutErrorMessage($seconds));
        }

        if (! Auth::guard()->once($request->only('email', 'password'))) {
            $this->incrementLoginAttempts($request);

            throw new AuthorizationException(trans('auth.failed'));
        }

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'last_online' => date('Y-m-d H:i:s'),
            'api_token'   => str_random(60),
            'soket_token' => str_random(60),
        ]);

        return api_response([
            'api_token'    => $user->api_token,
            'socket_token' => $user->socket_token,
            'user'         => $user->getFullData(),
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function loginUsername()
    {
        return 'email';
    }

    /**
     * Forgot password
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     * @throws ApiException
     */
    public function forgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $response = Password::broker()->sendResetLink($request->only('email'), function (Message $message) {
            $message->subject('Your Password Reset Link');
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return api_response();

            case Password::INVALID_USER:
            default:
                throw new ApiException(trans($response));
        }
    }
    
    /**
     * Logout user
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function logout()
    {
        /** @var User */
        $me = auth()->user();

        $me->update([
            'api_token'    => '',
            'socket_token' => '',
        ]);

        return api_response();
    }

    /**
     * My info
     *
     * @return \App\Http\Responses\ApiResponse
     */
    public function myInfo()
    {
        /** @var User */
        $me = auth()->user();

        return api_response(['user' => $me->getFullData()]);
    }

    /**
     * Get guests list
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function myGuests(Request $request)
    {
        /** @var User */
        $me = auth()->user();

        $views = $me->profile->views()->orderBy('updated_at', 'desc')
            ->take(30)->skip($request->get('offset', 0))->get();

        return api_response(['views' => $views->map(function (View $view) {
            return $view->getListData();
        })]);
    }

    /**
     * My info
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function userInfo(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::findOrFail($request->get('user_id'));

        return api_response(['user' => $user->getPublicData()]);
    }

    /**
     * Update user profile
     *
     * @param Request $request
     * @return \App\Http\Responses\ApiResponse
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'max:255|unique:users',
            'email' => 'email|max:255|unique:users',
            'password' => 'min:6',

            'first_name' => 'max:255',
            'last_name'  => 'max:255',
            'country'    => 'exists:countries,id|max:255',
            'city'       => 'max:255',
            'birth_date' => 'date|max:255',

            'service_start_date' => 'date|max:255',
            'service_end_date'   => 'date|max:255',
            'service_country'    => 'exists:countries,id|max:255',
            'service_city'       => 'max:255',

            'image' => 'image|image_size:300-3000,300-3000',
        ]);

        /** @var User */
        $me = auth()->user();

        if ($request->get('password')) {
            $me->password = bcrypt($request->get('password'));
        }
        if ($request->get('options')) {
            $me->options = $request->get('options');
        }
        $me->save();

        $profileData = $this->getProfileData($request->all());
        $me->profile->update(array_filter($profileData));

        if ($request->file('image')) {
            $me->addProfilePicture($request->file('image'));
        }

        $me = $me->fresh(); // Get fresh model to get updated profile picture

        return api_response(['user' => $me->getFullData()]);
    }

    /**
     * Search user
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->only(['name', 'first_name', 'last_name', 'start_date', 'end_date', 'city', 'country']);

        if (! array_filter($input)) {
            return api_response([]);
        }

        $data = array_filter([
            'users.name'                       => $input['name'],
            'user_profiles.first_name'         => $input['first_name'],
            'user_profiles.last_name'          => $input['last_name'],
            'user_profiles.service_city'       => $input['city'],
            'user_profiles.service_country_id' => $input['country'],
        ]);

        $user = User::where($data)->join('user_profiles', 'users.id', '=', 'user_profiles.user_id');

        if ($input['start_date']) {
            $user->where('user_profiles.service_start_date', '>=', Carbon::parse($input['start_date'])->toDateString());
        }
        if ($input['end_date']) {
            $user->where('user_profiles.service_end_date', '<=', Carbon::parse($input['end_date'])->toDateString());
        }

        $users = $user->get()->map(function (User $item) {
            return $item->getListData();
        });

        return api_response(['users' => $users]);
    }
}
