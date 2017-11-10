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

    /**
     * course has been enrolled by many users (pivot table lesson_user)
     *
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user')->as('enrollment')->withPivot('enrolled_at');
    }

    /**
     * Get All Lessons detail 
     *
     * @return mixed
     */
    public static function getAllLessons()
    {
        $key = config('cache.prefix').'AllLessons';
        $lessons = Cache::remember($key, 5, function() {
            return static::with(['teaching_language','course','course.level', 'users'])
                ->orderByDesc('first_day')->get();
        });

        return $lessons;
    }

    /**
     * Get user (Auth::ID) Current Lesson (lesson in session)
     *
     * @return mixed
     */
    public static function getMyCurrentLessonCount()
    {
        if (Auth::check())
        {
            $now = date('Y-m-d');
            $count = static::getAllLessons()->where('deleted', false)->where('first_day', '<=', $now)
                ->where('last_day', '>=', $now)->filter( function ($value ,$key) {
                    $matched = false;
                    foreach ($value->users as $user)
                    {
                        if ($user->id == Auth::id())
                        {
                            $matched = true;
                            break;
                        }
                    }
                    return $matched;
                })->count();
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
    public static function getMyFutureLessonCount()
    {
        if (Auth::check())
        {
            $now = date('Y-m-d');
            $count = static::getAllLessons()->where('deleted', false)->where('first_day', '>', $now)
                ->filter( function ($value ,$key) {
                    $matched = false;
                    foreach ($value->users as $user)
                    {
                        if ($user->id == Auth::id())
                        {
                            $matched = true;
                            break;
                        }
                    }
                    return $matched;
                })->count();
        } else { 
            $count = 0;
        }
        return $count;
    }

    /**
     * Get user (Auth::ID) Future Lesson (enrolled, and lesson has already ended)
     *
     * @return mixed
     */
    public static function getMyPastLessonCount()
    {
        if (Auth::check())
        {
            $now = date('Y-m-d');
            $count = static::getAllLessons()->where('deleted', false)->where('last_day', '<', $now)
                ->filter( function ($value ,$key) {
                    $matched = false;
                    foreach ($value->users as $user)
                    {
                        if ($user->id == Auth::id())
                        {
                            $matched = true;
                            break;
                        }
                    }
                    return $matched;
                })->count();
        } else { 
            $count = 0;
        }
        return $count;
    }

    /**
     * Get Future Lesson Count (start_day after today)
     *
     * @return mixed
     */
    public static function getNewLessonCount()
    {
        $now = date('Y-m-d');
        $key = config('cache.prefix').'newLessonCount';
        $newLessons = Cache::remember($key, 5, function() use ($now) {
            return static::where('deleted', false)->where('first_day', '>', $now)->count();
        });

        return $newLessons;
    }

    /**
     * Get all lessons counts
     *
     * @return mixed
     */
    public static function getAllLessonCount()
    {
        $key = config('cache.prefix').'allLessonCount';   
        $newLessons = Cache::remember($key, 5, function() {
            return static::all()->count();
        });

        return $newLessons;
    }
}
