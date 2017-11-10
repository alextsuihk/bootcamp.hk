<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CourseStoreUpdate;
use App\Course;
use App\Level;
use App\Lesson;
use App\Question;
use Auth;       //AT-Pending; debugging
class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['like', 'follow']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::getAllCourses();

        if ($request->filled('keywords')) {          // query-string has "keywords"
            // convert keywords from string to array. delimiter either " " or ","
            $keywords = $request->keywords;
            $search = preg_split( '/[,\s]+/', $request->keywords);

            $courses = $courses->filter(function ($value, $key) use ($search) {
                $matched = false;
                foreach ($search as $keyword) 
                {
                    if (stripos($value->title, $keyword) !== FALSE || stripos($value->sub_title, $keyword) !==false 
                        || stripos($value->abstract, $keyword) !== false)
                    {   
                        $matched = true;
                        break;
                    }
                }
                return $matched;
            });

        } else {
            $keywords = 'Search... ';                  // index & search use the same view
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
        $levels = Level::getAllLevels();
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
            'sub_title' => $request->sub_title,
            'abstract' => $request->abstract,
            'level_id' => $request->level_id,
            'active' => ($request->active ? true : false ),
            'deleted' => ($request->deleted ? true : false ),
            'remark' => $request->remark,
        ]);

        $key = $this->prefix.'AllCourses';
        Cache::forget($key);        // flush 'courses' cache (no need to wait to expire)
        session()->flash('messageAlertType','alert-success');
        session()->flash('message','A new course is added');
        
        //return redirect('/courses/'.$course->id);     // let do it in Laravel way
        return redirect()->route('courses.show', [$course->number]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $number, $slug = null, $nav='overview')
    {
        $course = Course::getAllCourses()->where('number', $number)->first();

        if (empty($course))
        {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','Course '.$number.' is not found');
            return redirect()->route('courses.index');

        }

        if (!($slug))
        {
            $slug = str_slug($course->title);
            $url = route('courses.show', [$number, $slug, $nav]);
            request()->session()->reflash();         // flush again before redirect, otherwise message is lost
            return redirect($url); 
        }

        $lessons = Lesson::getAllLessons()->where('course_id', $course->id);
        if ($request->filled('sortBy'))
        {
            if ($request->sortOrder == 'desc')
            {
                $lessons = $lessons->sortByDesc($request->sortBy);
            } else {
                $lessons = $lessons->sortBy($request->sortBy);
            }

        } else {
            $lessons = $lessons->sortByDesc('first_day');
        }


        $attachments = $course->attachments;

        // get questions list 
        $questions = Question::getAllQuestions()->where('course_id', $course->id);
        $questions = Question::getLastModifiedAt($questions);
        $questions = $questions->sortByDesc('last_modified_at');

        return view('courses.show', compact(['course', 'lessons', 'attachments', 'nav', 'questions']));
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
        $course->sub_title = $request->sub_title;
        $course->abstract = $request->abstract;
        $course->level_id = $request->level_id;
        $course->active = ($request->active ? true : false );
        $course->deleted = ($request->deleted ? true : false );
        $course->remark =  $request->remark;

        $course->save();

        $key = $this->prefix.'AllCourses';
        Cache::forget($key);        // flush 'courses' cache (no need to wait to expire)

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','Course detail is updated');
        return redirect()->route('courses.show', $course->number);
    }


    /**
     * TBD
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function like($id)
    {
        session()->flash('messageAlertType','alert-warning');
        session()->flash('message','Feature is not yet implemented, please try later');
        return redirect()->back();
    }

    /**
     * Follow this course if there is any update.
     *
     * @return \Illuminate\Http\Response
     */
    public function follow($course_id)
    {

        $user = Auth::user();
        $followed = $user->courses()->where('id', $course_id)->exists();

dd('under development');
        if ($enrolled)
        {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','You have enrolled previously. See you in the class');
            // if requesting to enroll & not yet enrolled

        } else {

            $enrolled_count = $lesson->users->count();
            if ($lesson->quota == 0 || $enrolled_count < $lesson->quota)
            {
                $lesson->users()->attach(Auth::id(), ['enrolled_at' => now(), 'sequence' => $enrolled_count+1]);
            } else {
                $lesson->users()->attach(Auth::id(), ['waitlisted_at' => now(), 'sequence' => $enrolled_count+1]);
            }
            
            $user = Auth::user();
            $sequence = $enrolled_count+1 . '/'. $lesson->quota;
            $message = (new EnrollLesson( $user, $lesson, $sequence));

            Mail::to($user->email)->bcc('admin@bootcamp.hk')->send($message);

            session()->flash('messageAlertType','alert-success');
            session()->flash('message','We will send you updates');
        } 

// to_be_removed
/*        $key = config('cache.prefix').'User_'.Auth::id();          // for sidebar My Shortcut
        Cache::forget($key);*/

        return redirect()->back();
    }

}
