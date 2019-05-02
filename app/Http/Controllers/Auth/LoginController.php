<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Illuminate\Http\Request;
use App\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

     /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return \Illuminate\Http\Response
     */
    // public function handleProviderCallback($provider)
    // {
    //     $user = Socialite::driver($provider)->user();
    //     $userData = [
    //         'token' => $user->token,
    //         'tokenSecret' => $user->tokenSecret,
    //         'id' => $user->id,
    //         'name' => $user->name
    //     ];
    //     session($userData);
    //     return redirect()->action('Auth\LoginController@emailRegister');
    // }

    public function handleProviderCallback(string $provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            $account = User::where([
                'provider' => $provider,
                'provider_id' => $user->id
            ])->first();

            if(!$account) {
                return view('auth.email-register', [
                    'name' => $user->name,
                    'provider_id' => $user->id,
                    'provider' => $provider,
                    'token' => $user->token,
                    'tokenSecret' => $user->tokenSecret,
                ]);
            } else {
                auth()->login($account);

                return redirect()->action('DashboardController@index');
            }
        } catch (CredentialsException $e) {
            return redirect()->to('login');
        }
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
            'id' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'token' => ['required', 'string', 'max:255'],
            'tokenSecret' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create($data)
    {
        return User::create([
            'provider_id' => $data['provider_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'provider' => $data['provider'],
            'token' => $data['token'],
            'token_secret' => $data['tokenSecret'],
        ]);
    }

    public function emailRegisterPost(Request $request) {
        $values = $request->request->all();

        /**
         * @var $user User
         */
        $user = $this->create($values);

        auth()->login($user);

        return redirect()->action('DashboardController@index');
    }
}
