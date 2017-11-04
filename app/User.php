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
        'name', 'nickname', 'email', 'password', 'avatar', 'facebook_id', 'linkedin_id', 'email_token', 'email_token_created_at', 'email_verified'
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

    /**
     * User belongs to a language
     *
     * @return mixed
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * query scope for searching multiple keyword(s)
     *
     * @return mixed
     */
    public function scopeUserSearchByKeywords($query, $keywords)
    {
        if ($keywords != '') 
        {
            // convert keywords from string to array. delimiter either " " or ","
            $keywords = preg_split( '/[,\s]+/', $keywords);

            $query->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) 
                {
                    $query->orwhere("name", "LIKE","%$keyword%")
                        ->orWhere("nickname", "LIKE", "%$keyword%");
                }
            });
        }
        return $query;
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
