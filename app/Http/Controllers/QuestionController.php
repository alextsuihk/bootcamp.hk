<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Question;


use Auth; 
use App\Comment;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['blacklist']);
        $this->middleware('auth')->only(['store', 'votecorrect', 'votewrong']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type=null)
    {

        
        if ($request->has('keywords')           // query-string has "keywords"
            && !is_null($keywords = $request->input('keywords'))) { // get query string
            $questions = Question::with(['user','course', 'comments'])->QuestionSearchByKeywords($keywords)->get();
            $title = 'Top Questions with search';
        } else {
                                     // only caching for read-only (index & show)
            $key = $this->prefix.'AllQuestions';
            $questions = Cache::remember($key, 5, function() {
                return Question::with(['user','course', 'comments'])->get();
            });                     // turn on eager loading
            $keywords = 'Search... ';                  // index & search use the same view
            $title = 'Top Questions';
        }


        $title = 'Top Questions';

        if ($type =='myNewComments')
        {
            $questions = $questions->where('user_id', Auth::id())->filter(function ($value, $key) {
                if (($value->comments->where('viewed', false))->isNotEmpty())
                    { return $value; }
            });
            $title = 'New comments to my questions';
        }


        $questions = $questions->sortByDesc('created_at');
        //dd($questions);

        return view('questions.index', compact(['title', 'questions', 'keywords']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        die('Hello Alex');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        die('questionController @ show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
