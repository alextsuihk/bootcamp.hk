<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Level extends Model
{
    /**
     * Get all Difficulty Level info from datadata & cache
     *
     * @return object
     */
    public static function getAllLevel()
    {
        $levels = Cache::remember('LevelAll', 60, function() {
            return static::all()->sortBy('id');
        });

        return $levels;
    }

    /**
     * Get Courses from Level
     *
     * @return object
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
