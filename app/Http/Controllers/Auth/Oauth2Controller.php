<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;

class Oauth2Controller extends Controller
{
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

        if ($authUser == null) {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','There is another user with the same email, please login first before assoicating with Facebook');
            return redirect()->route('register');
        } elseif ($authUser == 'accountTaken') {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','This Facebook Account is associated with another account ! <br>You should logout this session, and login using Facebook, <br>and then disassociate Facebook account');
            return redirect()->route('profile.edit');
        } else {
            Auth::login($authUser, true);
            session()->flash('messageAlertType','alert-success');
            session()->flash('message','You have login successfully with Facebook');
            return redirect()->back();
        }
    }

    private function findOrCreateUserFacebook($facebookUser)
    {
        $authUser = User::where('facebook_id', $facebookUser->id)->first();

        if ($authUser && !Auth::check())    // if facebook record is find & not login, just login
        {                                   
            return $authUser;
        }                                   // otherwise save the user info

        if ($authUser && Auth::check() && Auth::id() != $authUser->id) 
        {
            return 'accountTaken'; 
        }

        if (Auth::check())                  // if already login, update database with facebook_id
        {
            $authUser = Auth::user();       //login logged-in user info
            $authUser->facebook_id = $facebookUser->id;
            if ($authUser->avatar == null) {        // don't over-write original avatar
                $authUser->avatar = $facebookUser->avatar;
            }
            if ($authUser->email == null) {         // don't over-write original email
                $authUser->email = $facebookUser->email;
            }
            $authUser->save();
        
        } else {
            $emailTaken = User::where('email', $facebookUser->email)->count();
            if ($emailTaken > 0) {
                return null; 
            }

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

        if ($authUser == 'emailTaken') {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','There is another user with the same email, please login first before assoicating with LinkedIn');
            return redirect()->route('login');
        } elseif ($authUser == 'accountTaken') {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','This LinkedIn Account is associated with another account ! <br>You should logout this session, and login using LinkedIn, <br>and then disassociate LinkedIn account');
            return redirect()->route('profile.edit');
        } else {
            Auth::login($authUser, true);
            session()->flash('messageAlertType','alert-success');
            session()->flash('message','You have login successfully with LinkedIn');
            return redirect()->back();
        }
    }

    private function findOrCreateUserLinkedin($linkedinUser)
    {
        $authUser = User::where('linkedin_id', $linkedinUser->id)->first();

        if ($authUser && !Auth::check())    // if linkedin record is find & not login, just login
        {                                   
            return $authUser;
        }                                   // otherwise save the user info

        if ($authUser && Auth::check() && Auth::id() != $authUser->id) 
        {
            return 'accountTaken'; 
        }

        if (Auth::check())                  // if already login, update database with linkedin_id
        {
            $authUser = Auth::user();       //login logged-in user info
            $authUser->linkedin_id = $linkedinUser->id;
            if ($authUser->avatar == null) {        // don't over-write original avatar
                $authUser->avatar = $linkedinUser->avatar;
            }
            if ($authUser->email == null) {         // don't over-write original email
                $authUser->email = $linkedinUser->email;
            }
            $authUser->save();
        
        } else {
            $emailTaken = User::where('email', $linkedinUser->email)->count();
            if ($emailTaken > 0) {
                return 'emailTaken'; 
            }

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
    }}
