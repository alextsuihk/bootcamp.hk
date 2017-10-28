<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CourseStoreUpdate;
use App\Course;
use App\Level;
use App\Lesson;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('keywords')           // query-string has "keywords"
            && !is_null($keywords = $request->input('keywords'))) { // get query string
            $courses = Course::with('level')->SearchByKeywords($keywords)->get()->sortBy('number');

        } else {
                                     // only caching for read-only (index & show)
            $courses = Cache::tags(['courses'])->remember('CourseWithLevelSortByNumber', 5, function() {
                return Course::with('level')->get()->sortBy('number');
            });                     // turn on eager loading
            $keywords = 'Search... (placeholder)';                  // index & search use the same view
        }
        return view('courses.index', compact(['courses', 'keywords']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levels = Level::getAllLevel();
        return view('courses.create', compact(['levels']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(CourseStoreUpdate $request)   // type-hinted & do rule validation
    {
        //Course::create(request(['number', 'title', 'abstract', 'level_id', 'active']) );
        // stupid bootstrap returns "on" for checkbox, cannot use mass assignment

        if (is_numeric($request->number))
        {
            $number = sprintf("%03d", $request->number);
        } else {
            $number = $request->number;
        }
        $course = Course::create([ 
            'number' => $number,
            'title' => $request->title,
            'abstract' => $request->abstract,
            'level_id' => $request->level_id,
            'active' => ($request->active ? true : false ),
            'deleted' => ($request->deleted ? true : false ),
            'remark' => $request->remark,
        ]);

        Cache::tags('courses')->flush();                    // flush 'courses' cache (no need to wait to expire)
        session()->flash('message','A new course is added');
        
        //return redirect('/courses/'.$course->id);     // let do it in Laravel way
        return redirect()->route('courses.show', [$course->number]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($number, $slug = null)
    {
        // only cache & eager loading Course & Lession
        // user enrollment will be using lazy loading
        $key = 'Course'.$number;         
        $course = Cache::tags(['courses', 'lessons'])->remember($key, 5, function() use ($number) {
            return Course::with(['level','lessons', 'lessons.teaching_language', 'lessons.users'])->where('number', '=', $number)->where('deleted', false )->first();
        });                                 // enable eager loading + cache

        //dd($course);                      // Alex: just to make sure super nested eager loading has happend
        if (empty($course))
        {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','Course '.$number.' is not found');
            return redirect()->route('courses.index');

        }

        if (!($slug))
        {
            $slug = str_slug($course->title);
            $url = '/courses/'.$number.'/'.$slug;
            request()->session()->reflash();         // flush again before redirect, otherwise message is lost
            return redirect($url); 
        }

        $lessons = $course->lessons->sortbyDesc('first_day');       // sortBy first_day DESC

        return view('courses.show', compact(['course', 'lessons']));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($number)
    {
        $edit = Course::where('number', '=', $number)->first();        // pull original data
        $levels = Level::getAllLevel();
        
        return view('courses.edit', compact(['edit', 'levels']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    public function update(CourseStoreUpdate $request, $id)   // type-hinted & do rule validation
    {
        $course = Course::find($id);    // pull original data, id does not change, must reference id
        
        /*$course->number = $request->number;*/         // unchangeable
        $course->title = $request->title;
        $course->abstract = $request->abstract;
        $course->level_id = $request->level_id;
        $course->active = ($request->active ? true : false );
        $course->deleted = ($request->deleted ? true : false );
        $course->remark =  $request->remark;

        $course->save();

        Cache::forget('Course'.$course->number);                        // flush this key in cache

        session()->flash('message','Course detail is updated');
        return redirect()->route('courses.show', $course->number);
        //return redirect()->action('CourseController@show', ['course' => $course->number]);
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
