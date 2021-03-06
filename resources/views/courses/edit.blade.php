@extends ('layouts.master')

@section ('title', 'Modify Course')

@section ('content')
    <h2>Modify Course Detail</h2>
    <hr>
    @include ('courses.form', [
        'type'     => 'edit',
        'disabled' => '',           // don't disable form-input
        'course_num_readonly' => 'disabled',    // course_num is not changeable AFTER creation
        'action'=> action('CourseController@update', ['id' =>$edit->id]), 
        'method'=> method_field('PATCH'), 
        'button'=> 'Submit',
        'cancel'   => route('courses.show',  [$edit->number]), 
        ]) 

@endsection