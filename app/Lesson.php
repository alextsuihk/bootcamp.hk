<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
