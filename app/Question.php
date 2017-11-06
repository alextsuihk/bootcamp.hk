<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class Question extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'course_id', 'title', 'body'
    ];

    protected static $questions;

    /**
     * Question COULD belong to a course
     *
     * @return mixed
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Question belongs to a user
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Course has many comments
     *
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    /**
     * Get everthing and cache
     *
     * @return mixed
     */
    public static function getEverything()
    {
        $key = config('cache.prefix').'AllQuestions';
        $questions = Cache::remember($key, 5, function() {
            return Question::with(['user','course', 'comments', 'comments.user'])->get();
        });                                 // load everything

        return $questions;
    }
    
    /**
     * Get # of questions I have ever posted
     *
     * @return mixed
     */
    public static function getMyQuestions()
    { 
        $count =  self::getEverything()->where('user_id', Auth::id())->count();
        return $count;
    }

    /**
     * Get # of open questions (questions.closed == false)
     *
     * @return mixed
     */
    public static function getOpenQuestions()
    { 
        $count =  self::getEverything()->where('closed', false)->count();
        return $count;
    }

    /**
     * Get # of questions posted within past 14 days
     *
     * @return mixed
     */
    public static function getNewQuestions()
    { 
        $count =  self::getEverything()->where('created_at', '>', Carbon::now()->subDays(14) )->count();
        return $count;
    }

    public static function getLastModifiedAt($questions)
    {
        foreach ($questions as $question)
        {
            $question->last_modified_at =  $question->updated_at;
            $question->last_modified_by =  $question->user;

            foreach ($question->comments as $comment)
            {
                if ($comment->updated_at > $question->last_modified_at)
                {
                    $question->last_modified_at =  $comment->updated_at;
                    $question->last_modified_by =  $comment->user;
                }
            }
        }
        return $questions;
    }

}
