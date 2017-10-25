@extends ('layouts.master')

@section ('title', 'Course Detail')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')
    <h2>Course Detail</h2>
    <hr>
    @include ('courses.course_form', [
        'type'     => 'show',
        'disabled' => 'disabled',           // form-input is disabled
        'course_num_readonly' => 'disabled',    // course_num is not changeable AFTER creation (already disabled above)
        'action'   => '', 
        'method'   => '', 
        'button'   => '',
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

    <h3 id="lessonList">Class Offerings</h3>

    @if (count($lessons) == 0)
        <div class="jumbotron">
            No Class Offering at the moment
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Venue</th>
                        <th>Instructor</th>
                        <th>Language</th>
                        <th>Schedule</th>
                        <th>Quota</th>
                        <th>Enroll</th>
                        @auth 
                            @if (auth()->user()->is_admin)
                                <th>Edit</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lessons as $lesson)
                    {{-- AT-Pending: hide if not admin && !is_active  (hide for normal users if is_active=false) --}}
                        <tr>
                            <td><a href="/courses/{{ $lesson->id }}">{{ $course->number }}-{{ sprintf('%02d', $lesson->sequence) }}</a></td>
                            <td>{{ str_limit($lesson->venue, 40, ' ...') }}</td>
                            <td>{{ $lesson->instructor }}</td>
                            <td>{{ $lesson->teachinglanguage->language }}</td>
                            <td>{{ $lesson->first_day }} ~ {{ $lesson->last_day }}<br>{{ $lesson->schedule }}</td>
                            <td>{{ $lesson->quota }}</td>
                            <td><a class="btn btn-primary" href="/courses/{{ $lesson->id }}">View</a></td>
                            @auth
                                @if (auth()->user()->admin)
                                    <td><a class="btn btn-primary" href="/courses/{{ $lesson->id }}/edit">Edit</a></td>
                                @endif
                            @endauth
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endempty {{-- @empty($courses) --}}

@endsection
