<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use App\User;

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
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = url()->previous();
        $this->middleware('guest')->except('logout');
    }

    protected function credentials_working()
    {
        //dd(request()->all());
        return array_merge(request()->only($this->username(), 'password'),
        ['disabled' => 1]);
    }

    /*
     * Method override to send correct error messages
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse_working()
    {
        if ( ! User::where('email', request()->email)->first() ) {
            return redirect()->back()
                ->withInput(request()->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => 'Email does not exist',
                ]);
        }

        if ( ! User::where('email', request()->email)->where('password', bcrypt(request()->password))->first() ) {
            return redirect()->back()
                ->withInput(request()->only($this->username(), 'remember'))
                ->withErrors([
                    'password' => 'Password does not match credential',
                ]);
        }
    }

}
