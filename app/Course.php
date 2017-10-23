<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    //protected $fillable = ['number', 'title', 'abstract', 'active', 'level_id'];
    protected $guarded = [];

    /**
     * Get Lessons from Course
     *
     * @return mixed
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get Difficult Levels status of a course
     *
     * @return mixed
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function scopeSearchByKeywords($query, $keywords)
    {
        if ($keywords != '') 
        {
            // convert keywords from string to array. delimiter either " " or ","
            $keywords = preg_split( '/[,\s]+/', $keywords);

            $query->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) 
                {
                    $query->orwhere("title", "LIKE","%$keyword%")
                        ->orWhere("abstract", "LIKE", "%$keyword%");
                }
            });
        }

        return $query;
    }
}
