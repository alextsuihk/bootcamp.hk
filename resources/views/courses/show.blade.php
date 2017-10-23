@extends ('layouts.master')

@section ('title', 'Course Detail')

@section ('content')

    @empty($course)
        This is no such course, please check, email to 
        <a href="mailto:{{ config('mail.admin_email') }}">{{ config('mail.admin_email') }} </a>

    @else
        <h2>Course Detail</h2>
        <hr>

        <h3>{{ $course->title }}</h3>
        
        <a class="btn btn-primary disabled" href="/courses/{{ $course->id }}">View Detail</a>
        {{-- AT-Pending: need to restructure --}}
        <a class="btn btn-primary disabled" href="/favorites/{{ $course->id }}">Interested</a>
        <a class="btn btn-primary disabled" href="/courses/{{ $course->id }}">Admin Edit</a>

        <p>
            Course Number:{{ $course->number }}
        </p>

        <p>
            Level:{{ $course->level->difficulty }}
        </p>

        <p>
            Abstract:
            {!! $course->abstract !!}
        </p>

        Show Class Info &amp; Schedule in table format .....

        @empty($course->lessons)
            This is NO lessons schedule

        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        
                    </thead>
                    <tbody>
                        @foreach ($course->lessons as $lesson)
                            <tr>
                                <td><a href="/courses/{{ $lesson->id }}">{{ $lesson->number }}</a></td>
                                <td>{{ $lesson->instructor }}</td>
                                <td>{{ $lesson->venue }}</td>
                                <td>{{ $lesson->first_day }}</td>
                                <td>{{ $lesson->last_day }}</td>
                                <td>{{ $lesson->schedule }}</td>

          
                                <td><a class="btn btn-primary" href="/courses/{{ $course->id }}lessons/{{ $lesson->id }}">Enroll</a></td>
                                <td><a class="btn btn-primary" href="/courses/{{ $course->id }}lessons/{{ $lesson->id }}">Edit (Admin)</a></td>
                                <td>Total Enroll</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endempty   {{-- @empty($course->lessons) --}}

    @endempty  {{-- @empty($course) --}}

@endsection