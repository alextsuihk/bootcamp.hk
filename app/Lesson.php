<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Lesson extends Model
{
    protected $guarded = [];
    
    /**
     * Lesson belongs to a course
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Lesson has many files
     *
     * @return mixed
     */
    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Lesson belongs to a technical_language
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
        $myCurrentLessons = Cache::remember($key, 5, function() use ($now) {
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
        $myFutureLessons = Cache::remember($key, 5, function() use ($now) {
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
