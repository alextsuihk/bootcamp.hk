<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\Auth;

class Helper
{

    public static function userDisabled()
    {
        if (Auth::check() && Auth::user()->disabled) {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','Your account has been disabled. <br>Please contact system administrator 
                <a href="mailto:admin@bootcamp.hk?Subject=Account Disabled ('.Auth::id().')" target="_top">(admin@bootcamp.hk)</a>');
            Auth::logout();
            return redirect('/');
        }
    }

    /**
     * Retrieve an old input item, if null, then retrieve Edit Form item
     *
     * @param  string  $key
     * @param  object  $edit
     * @param  mixed   $default
     * @return mixed
     */
    public static function old($key = null, $edit = null, $default = null)
    {
        $value = app('request')->old($key, $default);   // this is original old() helper

        if (is_null($value) && !is_null($edit))         // try to load original data from controller@edit
        {
            $value= $edit->$key;
        }
        return $value;
    }

    /**
     * Check if user is logged && admin
     *
     * @param  none
     * @return boolean
     */
    public static function admin()
    {
        if (Auth::check() && auth()->user()->admin)
        {
            return true;
        } else {
            return false;
        }

    }
}


