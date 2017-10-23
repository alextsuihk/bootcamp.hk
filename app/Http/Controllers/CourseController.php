<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Level;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CourseStoreUpdate;

class CourseController extends Controller
{
    public function __construct()
    {
        // AT-Pending: enable admin middleware
//        $this->middleware('admin')->except(['index', 'show']);   // except index & show, other methods need auth()
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_old()
    {
/*        $courses = Cache::remember('CourseAllSortByNumber', 5, function() {
            return Course::all()->sortBy('number');             
        });*/
                                            // only caching for read-only (index & show)
        $courses = Cache::remember('CourseWithLevelSortByNumber', 5, function() {
            return Course::with('level')->get()->sortBy('number');
        });                     // turn on eager loading

        $keywords = 'Search... (placeholder)';                  // index & search use the same view
        return view('courses.index', compact(['courses', 'keywords']));
    }

    public function index(Request $request)
    {
        if ($request->has('keywords')) {
            $keywords = $request->input('keywords');        // get query string
            $courses = Course::with('level')->SearchByKeywords($keywords)->get()->sortBy('number');

        } else {
                                     // only caching for read-only (index & show)
            $courses = Cache::remember('CourseWithLevelSortByNumber', 5, function() {
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
        $edit = null;                   // because the same form is shared for "create" & "edit" 
                                        // we also add a custom helper in \app\Helpers\Helper.php 
        return view('courses.create', compact(['levels', 'edit']));
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

        //Course::create(request(['number', 'title', 'abstract', 'level_id', 'is_active']) );
        // stupid bootstrap returns "on" for checkbox, cannot use mass assignment
        $course = Course::create([ 
            'number' => sprintf("%03d", request('number')),
            'title' => request('title'),
            'abstract' => request('abstract'),
            'level_id' => request('level_id'),
            'is_active' => ($request->is_active ? true : false ),
        ]);

        session()->flash('message','A new course is added');
        
        //return redirect('/courses/'.$course->id);     // let do it is Laravel way
        return redirect()->route('courses.show', [$course->number]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_old($id)
    {
        // AT-Pending: pending refactoring
        // only cache & eager loading Course & Lession
        // user enrollment will be using lazy loading
        $key = 'Course'.$id;         
        $course = Cache::remember($key, 5, function() use ($id) {
            return Course::with(['level','lessons'])->find($id);
        });                                 // turn on eager loading
        dd($course);
        return view('courses.show', compact('course'));
    }

    public function show_old2($number)
    {
        // AT-Pending: pending refactoring
        // only cache & eager loading Course & Lession
        // user enrollment will be using lazy loading
        $key = 'Course'.$number;         
        $course = Cache::remember($key, 5, function() use ($number) {
            return Course::with(['level','lessons'])->where('number', '=', $number)->first();
        });                                 // turn on eager loading
        return view('courses.show', compact('course'));
    }


    public function show($number, $slug = null)
    {
        // AT-Pending: pending refactoring
        // only cache & eager loading Course & Lession
        // user enrollment will be using lazy loading
        $key = 'Course'.$number;         
        $course = Cache::remember($key, 5, function() use ($number) {
            return Course::with(['level','lessons'])->where('number', '=', $number)->first();
        });                                 // enable eager loading + cache

        if (!($slug))
        {
            $slug = str_slug($course->title);
            $url = '/courses/'.$number.'/'.$slug;
            header("Location: $url");
        }

        return view('courses.show', compact('course'));
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
        
        $course->number = $request->number;
        $course->title = $request->title;
        $course->abstract = $request->abstract;
        $course->level_id = $request->level_id;
        $course->is_active = ($request->is_active ? true : false );

        $course->save();

        session()->flash('message','Course detail is updated');
        Cache::forget('Course'.$id);                        // flush this key in cache

        //return redirect()->route('courses.show', $course->number);
        return redirect()->action('CourseController@show', ['course' => $course->number]);
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
