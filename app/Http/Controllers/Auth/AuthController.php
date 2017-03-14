<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Redirect for failed login
     */
    public function getRedirectUrl()
    {
        if (\Request::is('/')) {
            return url('/login');
        }

        return app(UrlGenerator::class)->previous();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',

            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'country'    => 'required|max:255',
            'city'       => 'required|max:255',
            'birth_date' => 'required|date|max:255',

            'service_start_date' => 'required|date|max:255',
            'service_end_date'   => 'required|date|max:255',
            'service_country'    => 'required|max:255',
            'service_city'       => 'required|max:255',

            'image' => 'required|image|image_size:300-3000,300-3000',
        ]);
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
        ]);

        $profile = UserProfile::create([
            'user_id'    => $user->id,

            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'country_id' => $data['country'],
            'city'       => $data['city'],
            'birth_date' => Carbon::parse($data['birth_date']),

            'service_start_date' => Carbon::parse($data['service_start_date']),
            'service_end_date'   => Carbon::parse($data['service_end_date']),
            'service_country_id' => $data['service_country'],
            'service_city'       => $data['service_city'],
        ]);

        $user->addProfilePicture($data['image']);

        \DB::commit();

        return $user;
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect('/login')
                         ->withInput($request->only($this->loginUsername(), 'remember'))
                         ->withErrors([
                             $this->loginUsername() => $this->getFailedLoginMessage(),
                         ]);
    }

    /**
     * After user was authenticated
     *
     * @param Request $request
     * @param User    $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, User $user)
    {
        $user->update(['socket_token' => str_random(60)]);

        return redirect()->intended($this->redirectPath());
    }
}
