@extends ('layouts.master')

@section ('title', 'Course Listing')

@section ('content')

    <h2>Course Listing</h2>
    <hr>
    {{-- AT-Pending: future search box --}}
    <span class="float-left">
        <form method="GET" action="/courses" class="form-inline">
            <input class="form-control " type="search" id="keywords" name="keywords" placeholder="{{ $keywords }}" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </span>

    @auth 
        @if (auth()->user()->admin)
            <span class="float-right">
                <a class="btn btn-primary" href="/courses/create">Add Course</a>
            </span>
        @endif
    @endauth
    
    <br><br>

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
                        <th>Detail</th>
                        @auth 
                            @if (auth()->user()->is_admin)
                                <th>Edit</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    {{-- AT-Pending: hide if not admin && !is_active  (hide for normal users if is_active=false) --}}
                        <tr>
                            <td><a href="/courses/{{ $course->number }}">{{ $course->number }}</a></td>
                            <td><strong>{{ str_limit($course->title, 40, ' ...') }} </strong></td>
                            <td>{{ $course->level->difficulty }}</td>
                            <td><a class="btn btn-primary" href="/courses/{{ $course->number }}">View</a></td>
                            @auth 
                                @if (auth()->user()->admin)
                                <td><a class="btn btn-primary" href="/courses/{{ $course->number }}/edit">Edit</a></td>
                                @endif
                            @endauth
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endempty {{-- @empty($courses) --}}
@endsection