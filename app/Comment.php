<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'question_id', 'body'
    ];

    /**
     * Comment belongs to a question
     *
     * @return mixed
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Comment belongs to an user
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get # of New (unread) comments associated to questions user has posted
     *
     * @return mixed
     */
    public static function getMyNewComments()
    {
        $key = 'user_'.Auth::id().'_myNewComments';  
        $myNewComments = Cache::remember($key, 5, function() {
            return static::with(['question' => function ($query) {
                $query->where('user_id', Auth::id() );
            }])->where('viewed', false)->count();
        });

        return $myNewComments;
    }

    /**
     * Get # of New (unread) comments associated to questions user has posted
     *
     * @return mixed
     */
    public static function clearViewedFlag($question_id)
    {
        $comments = static::where('question_id', $question_id)->get();
        foreach ($comments as $comment) {
            $comment->viewed = true;
            $comment->save();
        }

        $key = config('cache.prefix').'AllQuestions';
        Cache::forget($key);
        return;
    }

}
