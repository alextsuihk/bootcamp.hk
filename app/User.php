<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Helpers\Helper;

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

    /**
     * user could "enroll" many lessons (pivot table lesson_user)
     *
     * @return mixed
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')->withPivot('enrolled_at');
    }

    /**
     * user could "follow" many courses (pivot table course_user)
     *
     * @return mixed
     */
    public function follow_courses()
    {
        return $this->belongsToMany(Course::class, 'course_user_follow');
    }

    /**
     * user has many questions
     *
     * @return mixed
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * user has replied many answered
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
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
     * Get All Users detail (for admin ONNLY)
     *
     * @return mixed
     */
    public static function getAllUsers()
    {
        if (Helper::admin())
        {
            $key = config('cache.prefix').'AllUsers';
            $users = Cache::remember($key, 60, function() {
                return static::with(['language'])->get();
            });
        } else {
            $users = [];
        }

        return $users;
    }

    /**
     * Get Auth() Lessons detail 
     *
     * @return mixed
     */
    public static function getNewUserCount()
    {
        if (Helper::admin())
        {
            $users = static::getAllUsers()->where('created_at', '>', Carbon::now()->subDays(14) )->count();
        } else {
            $users = 0;
        }
        return $users;
    }

    /**
     * Setup session_data for impersonsate
     *
     * @return mixed
     */
    public function setImpersonating($id)
    {
        Session::put('impersonate', $id);           // impersonsating user_id (new)
        Session::put('original', Auth::id());       // original user_id 
    }

    public function stopImpersonating()
    {
        Session::forget('impersonate');
    }

    public function isImpersonating()
    {
        return Session::has('impersonate');
    }

}
