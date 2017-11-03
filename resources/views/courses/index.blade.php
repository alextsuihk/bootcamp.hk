@extends ('layouts.master')

@section ('title', 'Course Listing')

@section ('content')

    <h2>Course Listing</h2>
    <hr>
    <div class="row">
        <span class="mr-auto ml-3">
            <form method="GET" action={{ route('courses.index') }} class="form-inline">
                <input class="form-control " type="search" id="keywords" name="keywords" placeholder="{{ $keywords }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </span>

        @if (Helper::admin())
            <span class="ml-auto mr-3">
                <a class="btn btn-primary" href="{{ url()->current()."?sortBy=course.title" }}">Add Course</a>
            </span>
        @endif
    </div>
        
    <br>

    @if (count($courses) == 0)
        <div class="jumbotron">
            No Result is Found
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @if (!($course->deleted) || Helper::admin() )
                            <tr>
                                @if ($course->active)
                                    <td><a href="{{ route('courses.show', $course->number) }}"><strong>
                                        {{ $course->number }}</strong></a></td>
                                @else
                                    <td><a href="{{ route('courses.show', $course->number) }}">
                                        {{ $course->number }}</a></td>
                                @endif
                                <td><strong>{{ str_limit($course->title, 40, ' ...') }} </strong></td>
                                <td>{{ $course->level->difficulty }}</td>
                                <td>
                                    @if ($course->deleted)
                                        <span style="color:blue" title="Enrollment is closed">Disabled</span>
                                    @elseif ($course->active)
                                        <span style="color:green" title="Enrollment is closed">Active</span>
                                    @else 
                                        <span style="color:red" title="Enrollment is closed">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="" data-toggle="tooltip" data-placement="top" title="View detail" 
                                    href="{{ route('courses.show', [$course->number, str_slug($course->title)]) }}">
                                    <img src="/img/info.png" alt="Info"></a> 
                                    @if (Helper::admin())
                                        <a class="" data-toggle="tooltip" data-placement="top" title="Edit" 
                                        href="{{ route('courses.edit', $course->number) }}">
                                            <img src="/img/edit.png" alt="Edit"></a>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endempty {{-- @empty($courses) --}}
@endsection