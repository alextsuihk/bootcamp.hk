<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // AT-Pending: it seems, system runs this twice during login !!!
        // url()->previous()  has conflict with OAuth2 (linking)

        $this->redirectTo = '/';
        //$this->redirectTo = url()->previous();
        //$this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallbackFacebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }
        $authUser = $this->findOrCreateUserFacebook($user);

        Auth::login($authUser, true);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','You have login successfully with Facebook');
        return redirect()->route('home');
    }

    private function findOrCreateUserFacebook($facebookUser)
    {
        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser && !Auth::check())    // if facebook record is find & not login, just login
        {                                   
            return $authUser;
        }                                   // otherwise save the user info

        if (Auth::check())                  // if already login, update database with facebook_id
        {
            $authUser = User::find(Auth::id());     //login logged-in user info
            $authUser->facebook_id = $facebookUser->id;
            if ($authUser->avatar == null) {        // don't over-write original avatar
                $authUser->avatar = $facebookUser->avatar;
            }
            if ($authUser->email == null) {         // don't over-write original email
                $authUser->email = $facebookUser->email;
            }
            $authUser->save();
        
        } else {
            $authUser = User::create([
                'name' => str_random(10),       // need to create an UNIQUE temp name
                'nickname' => $facebookUser->name,
                'password' => '',               // null password
                'email' => $facebookUser->email,
                'facebook_id' => $facebookUser->id,
                'avatar' => $facebookUser->avatar,
            ]);

            $authUser->name = substr(strtolower(explode(' ',trim($facebookUser->name))[0]).$authUser->id, -20); 
            $authUser->save();          
                        // contcat first_name & id, then update database, (only take last 20 characters)
        }

        return $authUser;
    }


    /**
     * Redirect the user to the Linkedin authentication page.
     *
     * @return Response
     */
    public function redirectToProviderLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallbackLinkedin()
    {
        try {
            $user = Socialite::driver('linkedin')->user();
        } catch (Exception $e) {
            return redirect('auth/linkedin');
        }
        $authUser = $this->findOrCreateUserLinkedin($user);

        Auth::login($authUser, true);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','You have login successfully with LinkedIn');
        return redirect()->route('home');
    }

    private function findOrCreateUserLinkedin($linkedinUser)
    {
        $authUser = User::where('linkedin_id', $linkedinUser->id)->first();

        if ($authUser && !Auth::check())    // if linkedin record is find & not login, just login
        {                                   
            return $authUser;
        }                                   // otherwise save the user info

        if (Auth::check())                  // if already login, update database with linkedin_id
        {
            $authUser = User::find(Auth::id());     //login logged-in user info
            $authUser->linkedin_id = $linkedinUser->id;
            if ($authUser->avatar == null) {        // don't over-write original avatar
                $authUser->avatar = $linkedinUser->avatar;
            }
            if ($authUser->email == null) {         // don't over-write original email
                $authUser->email = $linkedinUser->email;
            }
            $authUser->save();
        
        } else {
            $authUser = User::create([
                'name' => str_random(10),       // need to create an UNIQUE temp name
                'nickname' => $linkedinUser->name,
                'password' => '',               // null password
                'email' => $linkedinUser->email,
                'linkedin_id' => $linkedinUser->id,
                'avatar' => $linkedinUser->avatar,
            ]);

            $authUser->name = substr(strtolower(explode(' ',trim($linkedinUser->name))[0]).$authUser->id, -20); 
            $authUser->save();          
                        // contcat first_name & id, then update database, (only take last 20 characters)
        }

        return $authUser;
    }
}
