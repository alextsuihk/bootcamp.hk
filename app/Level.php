<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Level extends Model
{
    /**
     * Get all Difficulty Level info & cache
     *
     * @return object
     */
    public static function getAllLevels()
    {
        $key = config('cache.prefix').'AllLevels';
        $levels = Cache::remember($key, 60, function() {
            return static::all()->sortBy('id');
        });

        return $levels;
    }

    /**
     * Level has many courses
     *
     * @return object
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
