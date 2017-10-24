<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Hash;
use Auth;
use App\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $id = Auth::id();
        $user = User::find($id);
        return view('auth.passwords.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Auth::id();
        $user = User::find($id);

        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'password.min' => 'Password must be at least 6 charactres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // checking old password
        if (!($wrongPassword = Hash::check($request->old_passowrd, $user->password)))
        {
            $originalMsgBag = ($validator->messages()->toArray());
            $newMsgBag      = array_add($originalMsgBag, 'old_password', ['Passowrd is incorrect']);
        }

        // return either validtion fail or original password is wrong
        if ($validator->fails() || $wrongPassword) 
        {
            return redirect('/password/change')
                        /*->withErrors($validator)*/
                        ->withErrors($newMsgBag)
                        ->withInput();
        }

        $user->password = bcrypt($request->password);
        $user->save();

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','New password is accepted');
        return redirect('/profile');
    }
}
