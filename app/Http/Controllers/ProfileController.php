<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\Helper;
use App\User;
use App\Mail\VerifyEmail;


class ProfileController extends Controller
{
    public function __construct($id = 0 )
    {
        //$this->middleware('admin')->only(['show']);
        $this->middleware('auth')->only(['sendemailverify', 'edit', 'update']);
    }

    /**
     * Send Email Verification email
     *
     * @param  int  $id=0
     * @return redirect to profile page
     */
    public function sendemailverify($id = 0)
    {
        $user = Auth::user();
        $deltaMinutes = $user->email_token_created_at->diffInMinutes(now());
        if ($user->email_verified)
        {
            session()->flash('messageAlertType','alert-success');
            session()->flash('message','Your email address is verified, no further action is required');
        } elseif ($deltaMinutes < 5) {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','Please check your mailbox and wait '.(5 - $deltaMinutes).' mins before requesting new verification');
        } else {
            $user->email_token = str_random(64);        // use email as token key
            $user->email_token_created_at = date('Y-m-d H:i:s');
            $user->email_verified = false;
            $user->save();

            // send registration email to user
            $expireInMinutes = config('mail.email_verify_expire');       // Verification Token expires in xx mins
            Mail::to($user)->send(new VerifyEmail($user, $expireInMinutes));

            // Flush message back
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','Verification email is sent to you, please check mailbox. Please also check SPAM box');
        }

        return redirect()->route('profile.edit');
    }

    /**
     * Verify Email-Token
     *
     * @param  mixed $token
     * @return \
     */
    public function emailverify($token)
    {
        $user = User::where('email_token', '=', $token)->first();

        if (count($user) ==0)
        {
            return view('profile.email_verify_fail', ['result' => 'nomatch']);
        } 

        $expireInMinutes = config('mail.email_verify_expire');

        if (($user->email_token_created_at->diffInMinutes(now())) > $expireInMinutes) 
        {      // check if token is more than 60 mins
            return view('profile.email_verify_fail', ['result' => 'expired']);
        }

        auth()->login($user);                   // login user
        if ($user->email_verified) {            // if verified previously
            session()->flash('messageAlertType','alert-info');
            session()->flash('message','Your email address is verified already');
            return redirect('/');
        } else {
            $user->email_verified = true;
            $user->email_token = null;
            $user->email_token_created_at = date('Y-m-d H:i:s');
            $user->save();
            session()->flash('messageAlertType','alert-success');
            session()->flash('message','Thank You, your email is verified');
            return redirect()->route('profile.edit');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 0)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|max:20',
            'mobile'   => 'nullable|digits:8',
        ]);

        $count = User::where('mobile', $validatedData['mobile'])->where('id', '!=', $id)->count();
        if ($count > 0)
        {
            return redirect()->back()
                        ->withErrors(['mobile' => 'The mobile phone is using used by another person'])
                        ->withInput();
        }

        $user = Auth::user();

        $user->nickname = $validatedData['nickname'];
        $user->mobile = $validatedData['mobile'];
        $user->save();

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','User profile is updated');
        return redirect()->route('profile.edit');

    }

    /**
     * Detach Facebook/Linkedin login
     *
     * @param  string
     * @return \
     */
    public function detach($type=null)
    {
        $user = Auth::user();
        if ($user->password == null) {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','You MUST create a password before unlink '.$type);
            return redirect()->route('password.edit');
        }

        switch ($type)
        {
            case 'Facebook':
                $user->facebook_id = null;
                $user->save();
                break;
            case 'LinkedIn':
                $user->linkedin_id = null;
                $user->save();
                break;
        }
        session()->flash('messageAlertType','alert-success');
        session()->flash('message', $type.' is disassociated with your account');
        return redirect()->route('profile.edit');
    }

};