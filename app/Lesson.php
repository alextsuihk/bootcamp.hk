<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Course;

class Lesson extends Model
{
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
    public function teachinglanguage()
    {
        return $this->belongsTo(Teachinglanguage::class);
    }
}
