<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Question;
use App\Comment;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['voteadmin']);
        $this->middleware('auth')->only(['store', 'vote']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $nav='allQuestions')
    {
        $questions = Question::getEverything();

        $title = 'Top Questions';

        if ($nav == 'myQuestions') {
            $questions = $questions->where('user_id', Auth::id());
            $title = 'My Questions'; 

        } elseif ($nav =='myNewComments') {
            $questions = $questions->where('user_id', Auth::id())->filter(function ($value, $key) {
                if (($value->comments->where('viewed', false))->isNotEmpty())
                    { return $value; }
            });
            $title = 'New Comments for My Questions';

        } elseif ($nav == 'unanswered') {
            $questions = $questions->filter(function ($value, $key) {
                if ($value->comments->isEmpty())
                    { return $value; }
            });
            $title = 'Unanswered Questions';

        } elseif ($nav == 'openQuestions' && Helper::admin()) {
            $questions = $questions->where('closed', false);
            $title = 'Opened Questions';
        }

        if ( !is_null($request->keywords)) {
            $keywords = preg_split( '/[,\s]+/', $request->keywords);        //convert string to array

            // AT-Pend: the following block looks stupid, let re-factor and make it pretty
            $questions = $questions->filter(function ($value, $key) use ($keywords) {
                $contains = false;
                foreach ($keywords as $keyword) {
                    if (strpos($value->title, $keyword) !==false || strpos($value->body, $keyword) !==false)
                    {
                        $contains = true;
                        break;
                    } else {
                        // if quetions->title & question->body NOT contain keyword, look into each comments
                        foreach ($value->comments as $comment) {
                            if (strpos($comment->body, $keyword) !==false && $contains == false)
                            {
                                $contains = true;
                                break;
                            }
                        }
                    }
                }
                if ($contains == true) {
                    return $value;
                }
            });
            $title = $title.' (with search)';
        }


        // pick the latest date among question->updated_at & associated comment(s)->updated_at
        $questions = Question::getLastModifiedAt($questions);

        $questions = $questions->sortByDesc('last_modified_at');

        $keywords = $request->keywords;         // workaround: to restore $keyword in case there is a search

        return view('questions.index', compact(['title','nav', 'questions', 'keywords']));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detailedMsg = '';
        if ($request->title == null) {
            $detailedMsg = '<BR> &#42; Title is required';
        } elseif (str_word_count($request->title) < 3) {
            $detailedMsg = '<BR> &#42; Title should have at least 4 words';
        }

        if ($request->body == null) {
            $detailedMsg = $detailedMsg. '<BR> &#42; Body is required';
        }

        if ($detailedMsg != '') {
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','Questions is NOT posted successfully'.$detailedMsg.'<BR>Please retry.');
            return redirect()->back()->withInput();
        }

        $question = Question::create([ 
            'user_id' => Auth::id(),
            'course_id' => $request->course_id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        $key = $this->prefix.'AllQuestions';
        Cache::forget($key);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','Questions is posted successfully.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug = null)
    {
        $questions = Question::getEverything();

        if (Helper::admin()) {
            $question = $questions->where('id', $id)->first();
        } else {
            $question = $questions->where('id', $id)->where('blacklisted', false)->first(); 
        }

        if (empty($question))
        {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','The question is not found');
            return redirect()->route('questions.index');

        }

        if (!($slug))
        {
            $slug = str_slug($question->title);
            $url = route('questions.show', [$id, $slug]);
            request()->session()->reflash();         // flush again before redirect, otherwise message is lost
            return redirect($url); 
        }


        // clear comments.viewed flag
        Comment::clearViewedFlag($id);

        return view('questions.show', compact(['question']));
    }


    /**
     * Admin vote: 
     *  update table questsions directly
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function voteadmin($id, $action = null)
    {
        if ( $action == 'close' || $action == 'blacklist')
        {
            $question = Question::find($id);
            if ($action == "close") {
                $question->closed = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is now closed');
            } else {
                $question->blacklisted = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is now blacklisted');
            }
            $question->save();

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
        if ( $action == 'agree' || $action == 'disagree')               // AT-Pending: WIP, will update later
        {
            $question = Question::find($id);
            if ($action == "close") {
                $question->closed = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is now closed');
            } else {
                $question->blacklisted = true;
                session()->flash('messageAlertType','alert-warning');
                session()->flash('message','The question is now blacklisted');
            }
            $question->save();

            $key = $this->prefix.'AllQuestions';
            Cache::forget($key);
        }

        return redirect()->back();
    }


}
