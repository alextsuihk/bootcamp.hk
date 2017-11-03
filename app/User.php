<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class User extends Authenticatable
{
    protected $dates = ['email_token_created_at'];
    
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_token', 'email_token_created_at', 'email_verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }


    public static function getNewUsers()
    {
        $key = 'newUser';  
        $myQuestions = Cache::remember($key, 60, function() {
            return static::where('created_at', '>', Carbon::now()->subDays(14) )->count();
        });

        return $myQuestions;
    }
}
