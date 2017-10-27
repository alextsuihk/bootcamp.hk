<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
        return $this->belongsToMany('User::class', 'lesson_user');
    }
}
