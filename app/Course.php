<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    //protected $fillable = ['number', 'title', 'abstract', 'active', 'level_id'];
    protected $guarded = [];

    /**
     * Course has many lessons
     *
     * @return mixed
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Course has many attachments
     *
     * @return mixed
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Course belongs to a (difficulty) level
     *
     * @return mixed
     */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * Course has many questions
     *
     * @return mixed
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * query scope for searching multiple keyword(s)
     *
     * @return mixed
     */
    public function scopeCourseSearchByKeywords($query, $keywords)
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
