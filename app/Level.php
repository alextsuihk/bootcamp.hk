<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Level extends Model
{
    public static function getAllLevel()
    {
        $levels = Cache::remember('LevelAll', 60, function() {
            return static::all()->sortBy('id');
        });

        return $levels;
    }

    public function workshops()
    {
        return $this->hasMany(Workshop::class);
    }
}
