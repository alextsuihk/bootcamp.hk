@extends ('layouts.master')

@section ('title', 'Adding Course')

@php
    $edit = null;       // shared-form could display original values (which is null in this case)
@endphp

@section ('content')
    <h2>Add a Course</h2>
    <hr>
    @include ('courses.form', [ 
        'type'     => 'create',
        'disabled' => '',               // don't disable form-input
        'course_num_readonly' => '',    // course_num is not changeable AFTER creation
        'action'   => action('CourseController@store'), 
        'method'   => '', 
        'button'   =>'Submit',
        'cancel'   => route('courses.index'), 
        ])
@endsection
