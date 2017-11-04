<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        $user = Auth::user();
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
        $rules = [
            'password' => 'required|string|min:6|confirmed',
        ];

        $messages = [
            'required' => 'The :attribute field is required.',
            'password.min' => 'Password must be at least 6 charactres',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails() ) 
        {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','New password is accepted');
        return redirect()->route('profile.edit');
    }
}
