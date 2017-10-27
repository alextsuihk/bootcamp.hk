<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TeachingLanguage extends Model
{
    /**
     * Get all Teaching Language info from datadata & cache
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
     * Get Language from Lesson
     *
     * @return mixed
     */
    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }
}
