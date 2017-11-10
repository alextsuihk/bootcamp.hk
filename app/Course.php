<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
     * course has been followed by many users (pivot table course_user_follow)
     *
     * @return mixed
     */
    public function follow_users()
    {
        return $this->belongsToMany(User::class, 'course_user_follow');
    }

    /**
     * Get All Course detail 
     *
     * @return mixed
     */
    public static function getAllCourses()
    {
        $key = config('cache.prefix').'AllCourses';
        $courses = Cache::remember($key, 5, function() {
            return Course::with(['level', 'follow_users', 'attachments', 'attachments.attachment_revisions'])
            ->with(['attachments.attachment_revisions'])->orderBy('number')->get();
            });                                 // enable eager loading + cache

        return $courses;
    }

}
