<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Course;
use App\User;

class Lesson extends Model
{
    protected $guarded = [];
    
    /**
     * Get Course from Lesson
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get Difficult Levels status of a course
     *
     * @return mixed
     */
    public function teaching_language()
    {
        return $this->belongsTo(TeachingLanguage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user');
    }

    /**
     * Get user (Auth::ID) Current Lesson (lesson in session)
     *
     * @return mixed
     */
    public static function getMyCurrentLessons()
    {
        $now = date('Y-m-d');
        $key = 'user_'.Auth::id().'_myCurrentLessons';
        $tag = 'user_'.Auth::id();
        $myCurrentLessons = Cache::tags($tag)->remember($key, 5, function() use ($now) {
            return static::leftJoin('lesson_user', 'lesson_id', '=', 'id')->where('lesson_user.user_id', Auth::id())->where('deleted', false)->where('first_day', '<=', $now)->where('last_day', '>=', $now)->count();
        });

        return $myCurrentLessons;
    }

    /**
     * Get user (Auth::ID) Future Lesson (enrolled, and lesson will start in future)
     *
     * @return mixed
     */
    public static function getMyFutureLessons()
    {
        $now = date('Y-m-d');
        $key = 'user_'.Auth::id().'_myFutureLessons';
        $tag = 'user_'.Auth::id();
        $myFutureLessons = Cache::tags($tag)->remember($key, 5, function() use ($now) {
            return static::leftJoin('lesson_user', 'lesson_id', '=', 'id')->where('lesson_user.user_id', Auth::id())->where('deleted', false)->where('first_day', '>', $now)->count();
        });

        return $myFutureLessons;
    }

    /**
     * Get Future Lesson Count (start_day after today)
     *
     * @return mixed
     */
    public static function getNewLessons()
    {
        $now = date('Y-m-d');
        $key = 'newLessons';
        
        $newLessons = Cache::remember($key, 5, function() use ($now) {
            return static::where('deleted', false)->where('first_day', '>', $now)->count();
        });

        return $newLessons;
    }

}
