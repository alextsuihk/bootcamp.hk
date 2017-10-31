@extends ('layouts.master')

@section ('title', 'Add Lesson')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')
    <script type="text/javascript">             // AT-Pending: scrollIntoView not working
        $(document).ready(function() {
            document.getElementById('lessonSection').scrollIntoView();
        }
    </script>

    <div class="row">
        <span class="mr-auto ml-3"><h2>Course Detail</h2></span>
        <span class="ml-auto mr-5">
            remove-them
            <a href="{{ route('courses.like', $course->number) }}"><img src="/img/thumbs-up.png" alt="like"></a>
            <a class="btn btn-primary" href="{{ route('courses.follow', $course->number) }}">Follow</a>
            @if (Helper::admin())
                <a class="" data-toggle="tooltip" data-placement="top" title="Edit" href="{{ 'courses.edit', $course->number }}"><img src="/img/edit.png" alt="Edit"></a>
            @endif
        </span>
    </div>
    <hr>
    @include ('courses.form', [
        'type'     => 'show',
        'disabled' => 'disabled',           // form-input is disabled
        'course_num_readonly' => 'disabled',    // course_num is not changeable AFTER creation (already disabled above)
        'action'   => '#', 
        'method'   => '', 
        'button'   => '',
        'cancel'   => route('courses.show',  [$course->number]), 
        ]) 

    <hr>
    <h2 id="lessonOffering">Lesson Offerings</h2>                    
    @include ('lessons.list')
    
    <hr>
    <h2 id="lessonSection">Adding a Lesson</h2>
    @include ('lessons.form', [ 
        'type'     => 'create',
        'disabled' => '',               // don't disable form-input
        'action'   => route('lessons.store'), 
        'method'   => '', 
        'button'   =>'Submit',
        'previousUrl' => route('courses.show',  [$course->number]),
        ]) 

@endsection