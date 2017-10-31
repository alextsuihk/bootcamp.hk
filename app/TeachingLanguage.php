<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TeachingLanguage extends Model
{
    /**
     * Get all Teaching Language info & cache
     *
     * @return object
     */
    public static function getAllTeachingLanguage()
    {
        $levels = Cache::remember('TeachLanguageAll', 60, function() {
            return static::all()->sortBy('id');
        });

        return $levels;
    }

    /**
     * Teaching Langauge has many lessons
     *
     * @return mixed
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
