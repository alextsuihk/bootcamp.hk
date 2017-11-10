@extends ('layouts.master')

@section ('title', 'Lesson Listing')

@section ('content')

    <h2>{{ $title }}</h2>
    <hr>
    <br>

    @include ('lessons.list', [
        'showCourseTitle' => true,
        ])


@endsection