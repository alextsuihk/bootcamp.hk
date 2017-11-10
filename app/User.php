<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
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
    public function scopeUserSearchByKeywords_to_removed($query, $keywords)
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
            $users = Cache::remember($key, 5, function() {
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

    public static function getNewUserCount_to_be_removed()
    {
        if (Helper::admin())
        {
            $key = config('cache.prefix').'newUserCount';  
            $newUsers = Cache::remember($key, 60, function() {
                return static::where('created_at', '>', Carbon::now()->subDays(14) )->count();
            });
        } else {
            $newUsers = 0;
        }
        return $newUsers;
    }


    /**
     * Get Auth() Lessons detail 
     *
     * @return mixed
     */
    public static function getSingleUser_to_be_removed()
    {
        if (Auth::check())
        {
            $key = config('cache.prefix').'User_'.Auth::id();
            $user = Cache::remember($key, 5, function() {
                return static::with(['lessons','follow_courses', 'questions', 'questions.comments'])->find(Auth::id());
            });
        } else {
            $user = null;
        }
        return $user;
    }

    /**
     * Get user (Auth::ID) Future Lesson (enrolled, and lesson has already ended)
     *
     * @return mixed
     */
    public static function getMyPastLessonCountto_be_removed()
    {
        if (Auth::check())
        {  
            $now = date('Y-m-d');
            $count = self::getSingleUser()->lessons->where('deleted', false)->where('last_day', '<', $now)->count();
        } else {
            $count = 0;
        }
        return $count;
    }

    /**
     * Get user (Auth::ID) Current Lesson (lesson in session)
     *
     * @return mixed
     */
    public static function getMyCurrentLessonCountto_be_removed()
    {
        if (Auth::check())
        {
            $now = date('Y-m-d');
            $count = self::getSingleUser()->lessons->where('deleted', false)->where('first_day', '<=', $now)->where('last_day', '>=', $now)->count();
        } else {
            $count = 0;
        }
        return $count;
    }

    /**
     * Get user (Auth::ID) Future Lesson (enrolled, and lesson will start in future)
     *
     * @return mixed
     */
    public static function getMyFutureLessonCountto_be_removed()
    {
        if (Auth::check())
        {
            $now = date('Y-m-d');
            $count = self::getSingleUser()->lessons->where('deleted', false)->where('first_day', '>', $now)->count();
        } else {
            $count = 0;
        }
        return $count;
    }




}
