<?php 

namespace App\Helpers;

class Helper
{
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
}


