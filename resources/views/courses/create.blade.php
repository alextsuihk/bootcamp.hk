@extends ('layouts.master')

@section ('title', 'Adding Course')

@section ('content')
    <h2>Add a Course</h2>
    <hr>
    @include ('courses.form', [ 
        'action'=> '/courses', 
        'method'=> '', 
        'button'=>'Submit',
        ]) 
@endsection

{{-- 'action'=>action('CourseController@store'), --}}