<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LessonStoreUpdate;
use Carbon\Carbon;
use App\Lesson;
use App\Course;
use App\Level;
use App\TeachingLanguage;
use App\Mail\EnrollLesson;

use App\Mail\VerifyEmail;

class LessonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['enroll', 'cancel']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update']);
        $this->prefix = config('cache.prefix');
    }

    /**
     * List lesson
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type=null)
    {
        $key = $this->prefix.'AllLesssons';
        $lessons = Cache::remember($key, 5, function() {
            return Lesson::with(['teaching_language','course','course.level', 'users'])
            ->where('deleted', false)->get()->sortBy('first_day');
        });
        $title = 'All Class Offerings';

        $today = date('Y-m-d');
        if ($type != null)
        {
            switch ($type)
            {
                case 'new':
                    $lessons = $lessons->where('first_day', '>', $today);
                    $title = 'New Class Offerings';
                    break;
                case 'myCurrentLessons':
                    $lessons = Lesson::with(['teaching_language','course','course.level', 'users'])->leftJoin('lesson_user', 'lesson_id', '=', 'id')->where('lesson_user.user_id', Auth::id())->where('deleted', false)->where('first_day', '<=', $today)->where('last_day', '>=', $today)->get();
                    $title = 'My Active Classes';
                    break;
                case 'myFutureLessons':
                    $lessons = Lesson::with(['teaching_language','course','course.level', 'users'])->leftJoin('lesson_user', 'lesson_id', '=', 'id')->where('lesson_user.user_id', Auth::id())->where('deleted', false)->where('first_day', '>', $today)->get();
                    $title = 'My Enrolled Classes';
                    break;
            }
        }


        if ($request->filled('sortBy'))
        {
            if ($request->sortOrder == 'desc')
            {
                $lessons = $lessons->sortByDesc($request->sortBy);
            } else {
                $lessons = $lessons->sortBy($request->sortBy);
            }

        } else {
            $lessons = $lessons->sortBy('first_day');
        }

        return view('lessons.index', compact(['lessons', 'title']));


    }

    /**
     * Enroll a lesson.
     *
     * @return \Illuminate\Http\Response
     */
    public function enroll($lesson_id)
    {
        $lesson = Lesson::with('course')->where('deleted', false)->find($lesson_id);    
                                            // get $lesson instance, if disabled, cannot enroll
        $enrolled = $lesson->users()->where('id', Auth::id())->exists();

        if ($enrolled)
        {
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','You have enrolled previously. See you in the class');
            // if requesting to enroll & not yet enrolled
        } else {
            $lesson->users()->attach(Auth::id(), ['enrolled_at' => now()]);
            
            $user = Auth::user();
            $message = (new EnrollLesson( $user, $lesson));

            Mail::to($user->email)->queue($message);

            session()->flash('messageAlertType','alert-success');
            session()->flash('message','Lesson is enrolled successfully. See you in the class');
        } 

        $key = 'user_'.Auth::id().'_myCurrentLessons';          // for sidebar My Shortcut
        Cache::forget($key);

        $key = 'user_'.Auth::id().'_myFutureLessons';
        Cache::forget($key);

        $key = $this->prefix.'AllLesssons';
        Cache::forget($key);

        $key = $this->prefix.'Course_'.$lesson->course->number;  
        Cache::forget($key);                // forget this key (course_number), because of nested eager loading

        return redirect()->back();
    }

    /**
     * Cancel a lesson enroller
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel($lesson_id)
    {
        $lesson = Lesson::with('course')->find($lesson_id);    
                            // get $lesson instance (even lesson is disabled, still allow cancellation)
        $enrolled = $lesson->users()->where('id', Auth::id())->exists();

        if ($enrolled)
        {
            $lesson->users()->detach(Auth::id());
            // AT-Pending: queue email to user, cc enrollment@bootcamp.hk
            session()->flash('messageAlertType','alert-info');
            session()->flash('message','Your enrollment is cancelled');
        } else {
            // should never come here
            session()->flash('messageAlertType','alert-warning');
            session()->flash('message','Something is wrong, please contact system admin');
        }

        $key = 'user_'.Auth::id().'_myCurrentLessons';          // for sidebar My Shortcut
        Cache::forget($key);

        $key = 'user_'.Auth::id().'_myFutureLessons';
        Cache::forget($key);

        $key = $this->prefix.'AllLesssons';
        Cache::forget($key);

        $key = $this->prefix.'Course_'.$lesson->course->number;  
        Cache::forget($key);                // forget this key (course_number), because of nested eager loading

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $course = Course::with(['level','lessons', 'lessons.teaching_language', 'lessons.users'])->find($id);

        if (empty($course))
        {   // show never come here
            session()->flash('messageAlertType','alert-danger');
            session()->flash('message','Something is wrong.');
            return redirect()->route('courses.index');

        }

        $lessons = $course->lessons->sortbyDesc('first_day');       // sortBy first_day DESC
        $teaching_languages = TeachingLanguage::getAllTeachingLanguage();
        return view('lessons.create', compact(['course', 'lessons', 'teaching_languages']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonStoreUpdate $request)
    {
        $max = Lesson::with('course')->where('course_id', '=', $request->course_id)->pluck('sequence')->max();
                        // get the last sequence# from lesson table (where course_id)

        $lesson = Lesson::create([ 
            'course_id' => $request->course_id,
            'sequence' => $max+1,
            'venue' => $request->venue,
            'instructor' => $request->instructor,
            'teaching_language_id' => $request->teaching_language_id,
            'first_day' => $request->first_day,
            'last_day' => $request->last_day,
            'schedule' => $request->schedule,
            'quota' => $request->quota,
            'active' => ($request->active ? true : false ),
            'deleted' => ($request->deleted ? true : false ),
            'remark' => $request->remark,
        ]);
        $lesson->save();

        $key = $this->prefix.'AllLesssons';
        Cache::forget($key);

        $key = $this->prefix.'Course_'.$lesson->course->number;
        Cache::forget($key);

        $key = 'newLessons';
        Cache::forget($key);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','A new lesson is added');

        return redirect()->route('courses.show', 
            [$lesson->course->number, str_slug($lesson->course->title), 'lessons']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_lesson = Lesson::find($id);        // pull original data
        $course = Course::with(['level','lessons', 'lessons.teaching_language', 'lessons.users'])->find($edit_lesson->course_id);

        $lessons = $course->lessons->sortbyDesc('first_day');       // sortBy first_day DESC

        $teaching_languages = TeachingLanguage::getAllTeachingLanguage();

        return view('lessons.edit', compact(['edit_lesson','course', 'lessons', 'teaching_languages']));
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
        $lesson = lesson::with('course')->find($id);    // pull original data, id does not change, must reference id
        
        $lesson->venue = $request->venue;
        $lesson->instructor = $request->instructor;
        $lesson->teaching_language_id = $request->teaching_language_id;
        $lesson->first_day = $request->first_day;
        $lesson->last_day = $request->last_day;
        $lesson->schedule = $request->schedule;
        $lesson->quota = $request->quota;
        $lesson->active = ($request->active ? true : false );
        $lesson->deleted = ($request->deleted ? true : false );
        $lesson->remark =  $request->remark;

        $lesson->save();

        $key = $this->prefix.'AllLesssons';
        Cache::forget($key);

        $key = 'newLessons';
        Cache::forget($key);

        $key = $this->prefix.'Course_'. $lesson->course->number;
        Cache::forget($key);

        session()->flash('messageAlertType','alert-success');
        session()->flash('message','Course detail is updated');

        return redirect()->route('courses.show', 
            [$lesson->course->number, str_slug($lesson->course->title), 'lessons']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
