@extends ('layouts.master')

@section ('title', 'Course Detail')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')

    {{-- creating a nav-tab --}}
    <div class="row">
        <span class="mr-auto ml-3">
            <?php $uri = route('courses.show', [$course->number, str_slug($course->title)]); ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <?php $active = ($nav=="overview")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/overview">Overview</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="downloads")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/downloads">Downloads</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="lessons")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/lessons">Lessons</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="qna")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/qna">Q &amp; A</a>
                </li>
            </ul>
        </span>
        {{-- AT-Pending: enable like & follow later --}}
{{--         <span class="ml-auto mr-5">
            <a class="" href="{{ route('courses.like', [$course->id]) }}"><img src="/img/thumbs-up.png" alt="like"></a>
            <a class="btn btn-primary" title="notify you when there is an update and new question is posted" href="{{ route('courses.follow', [$course->id]) }}">Follow</a>
        </span> --}}
    </div>
    {{-- end of creating a nav-tab --}}

    @if ($nav=='overview')
        <div class="row">
            <span class="mr-auto ml-3"><h2>Course Detail</h2></span>
            <span class="ml-auto mr-5">
                <a class="btn btn-primary" href="{{ route('courses.follow', $course->id) }}" title="To receive update">Follow</a>
                @if (Helper::admin())
                    <a class="" data-toggle="tooltip" data-placement="top" title="Edit" 
                    href="{{ route('courses.edit', $course->number) }}">
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

    @elseif ($nav=='downloads')
        <div class="row">
            <span class="mr-auto ml-3">
                <h2 id="lessonList">File Attachment for downloads</h2>
            </span>
            <span class="ml-auto mr-5">
                <a class="btn btn-primary" href="{{ route('courses.follow', $course->id) }}" title="To receive update">Follow</a>
                @if (Helper::admin())
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadNew">Add New File</button>
                @endif
            </span>
        </div>
        <hr>
        @include ('attachments.list')
        @include ('attachments.modal')

    @elseif ($nav=='lessons')
        <div class="row">
            <span class="mr-auto ml-3">
                <h2 id="lessonList">Class Offerings</h2>
            </span>
            <span class="ml-auto mr-5">
                <a class="btn btn-primary" href="{{ route('courses.follow', $course->id) }}" title="To receive update">Follow</a>
                @if (Helper::admin())
                    <a class="btn btn-primary" href="{{ route('lessons.create', $course->id) }}">Add Lesson</a>
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-lesson" data-title="New Lesson" data-action="my-Action" data-method="my-Method">Add New Lesson</button> --}}
                    {{-- will migrate to modal later --}}
                @endif
            </span>
        </div>
        <hr>
        @if (!($course->active) && !Helper::admin())
            <div class="jumbotron">
                Course is not active, lesson information will NOT be shown<br>
                Please contact system administrator !
            </div>
        @else
            @include ('lessons.list', [
                'showCourseTitle' => false,
            ])
        @endif

    @elseif ($nav=='qna')
        <div class="row">
            <span class="mr-auto ml-3">
                <h2 id="lessonList">Questions &amp; Answers</h2>
            </span>
            <span class="ml-auto mr-2">
                <a class="btn btn-primary" href="{{ route('courses.follow', $course->id) }}" title="To receive update">Follow</a>
                @if (Auth::id())
                    <button id="askQuestionModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#askQuestion" data-course_id="{{ $course->id }}">Ask Question</button><br>
                @else
                    <a class="btn btn-primary" href="{{ route("login") }}">Ask Question</a>
                @endif
            </span>
        </div>
        <hr>
        @include ('questions.list')
        @include ('questions.modal')
    @endif 
@endsection