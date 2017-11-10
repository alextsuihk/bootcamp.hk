<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Question; 

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['voteadmin']);
        $this->middleware('auth')->only(['store', 'vote']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question_id = $request->question_id;

        $comment = Comment::create([ 
            'user_id' => Auth::id(),
            'question_id' => $question_id,
            'body' => $request->body,
        ]);

        // re-open the questions
        $question = Question::find($question_id);
        $question->closed = false;
        $question->save();

        $key = $this->prefix.'AllQuestions';
        Cache::forget($key);

        $key = $this->prefix.'user_'.$question->user_id.'_myNewCommentCount';
        Cache::forget($key);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','Thank you for your comment');
        return redirect()->back();
    }

    /**
     * Admin vote: 
     *  update table questsions directly
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function voteadmin($id, $action = null)
    {
        if ( $action == 'correct' || $action == 'blacklist')
        {
            $comment = comment::find($id);
            if ($action == "correct") {
                $comment->correct = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is marked as correct');
            } else {
                $comment->blacklisted = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is now blacklisted');
            }
            $comment->save();

            $key = $this->prefix.'AllQuestions';
            Cache::forget($key);
        }

        return redirect()->back();
    }

    /**
     * General User vote: 
     *  use Pivot
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function vote($id, $action = null)
    {
        dd($action);
    }
}
