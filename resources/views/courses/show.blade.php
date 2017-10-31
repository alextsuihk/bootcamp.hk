@extends ('layouts.master')

@section ('title', 'Course Detail')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')
    <div class="row">
        <span class="mr-auto ml-3"><h2>Course Detail</h2></span>
        <span class="ml-auto mr-5">
            <a class="" href="/course/{{ $course->number }}/like"><img src="/img/thumbs-up.png" alt="like"></a>
            <a class="btn btn-primary" href="/course/{{ $course->number }}/follow">Follow</a>
            @if (Helper::admin())
                <a class="" data-toggle="tooltip" data-placement="top" title="Edit" href="/courses/{{ $course->number }}/edit">
                    <img src="/img/edit.png" alt="Edit"></a>
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
        'cancel'   => route('courses.index'), 
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}


    <div class="row">
        <span class="mr-auto ml-3">
            <h3 id="lessonList">File Attachment for downloads</h3>
        </span>
        @auth 
            @if (Helper::admin())
                <span class="ml-auto mr-5">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadNew">Add New File</button>
                </span>
            @endif
        @endauth
    </div>
    @include ('attachments.list')

    <div class="row">
        <span class="mr-auto ml-3">
            <h3 id="lessonList">Class Offerings</h3>
        </span>
        @auth 
            @if (Helper::admin())
                <span class="ml-auto mr-5">
                    <a class="btn btn-primary" href="/lessons/create/{{ $course->id }}">Add Lesson</a>
                </span>
            @endif
        @endauth
    </div>

    @include ('lessons.list')

    @include ('attachments.modal')

@endsection