@extends ('layouts.master')

@section ('title', 'Lesson Listing')

@section ('content')

    <h2>{{ $title }}</h2>
    <hr>
    <br>

@if (count($lessons) == 0)
    <div class="jumbotron">
        No Class at the moment
    </div>
@else   

    <div>
        Sort By:
        <a class="btn btn-secondary" href="{{ url()->current().'?sortBy=course.title' }}">Title</a>
        <a class="btn btn-secondary" href="{{ url()->current().'?sortBy=first_day' }}">First Day</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><center>No.</center></th>
                    <th>Title</th>
                    <th><center>Venue</center></th>
                    <th><center>Instructor</center></th>
                    <th><center>Language</center></th>
                    <th><center>Schedule</center></th>
                    {{-- <th><center>Quota</center></th> --}}
                    <th><center>Status</center></th>
                    <th><center>Enroll</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)
                     <?php $uri = route('courses.show', [$lesson->course->number, str_slug($lesson->course->title)]); ?>
                    @if (Auth::check() && $lesson->users->keyBy('id')->contains(Auth::id()))
                        <?php $showCancelButton = true; ?>             {{-- if logged-in && enrolled --}}
                        <?php $showEnrollButton = false; ?>
                    @else
                        <?php $showEnrollButton = true; ?>             {{-- if NOT logged-in || NOT enrolled --}}
                        <?php $showCancelButton = false; ?>
                    @endif

                    <?php $hideButton = true; ?>
                    <?php $today=date("Y-m-d")  ;?>
                    @if (!($lesson->active))
                        <?php $status='<span style="color:red" title="Enrollment is closed">Inactive</span>'; ?>
                    @elseif ($lesson->first_day == null || $lesson->last_day == null)
                        <?php $status="Pending"; ?>
                    @elseif ($today >= $lesson->first_day)
                        <?php $status="Lesson Started"; ?>
                    @elseif ($today >= $lesson->last_day)
                        <?php $status="Lesson Finished"; ?>
                    @else
                        <?php $status='<span style="color:green" title="Open for enrollment">Active</span>'; 
                        $hideButton = false; ?>
                    @endif

                    <tr>
                        <td><a class="" href="{{ $uri }}/overview">{{ $lesson->course->number }}</a>-{{ sprintf('%02d', $lesson->sequence) }}</td>
                        <td><a class="" href="{{ $uri }}/overview">{{ $lesson->course->title }}</a></td>
                        <td>
                            @if ($lesson->venue)
                                <span data-toggle="tooltip" data-placement="top" title="{{ $lesson->venue }}">
                                {{ str_limit($lesson->venue, 50, ' ...') }}</span>
                            @else
                                (TBD)
                            @endif
                        </td>
                        <td>
                            @if ($lesson->instructor)
                                {{ $lesson->instructor }}
                            @else
                                (TBD)
                            @endif
                        </td>
                        <td>{{ $lesson->teaching_language->language }}</td>
                        <td><center>
                            @if ($lesson->first_day)
                                Start: {{ $lesson->first_day }} <br>
                            @endif
                            @if ($lesson->last_day)
                                End: {{ $lesson->last_day }} <br>
                            @endif
                            @if ($lesson->schedule)
                                {{ $lesson->schedule }}
                            @else
                                (TBD)
                            @endif
                        </center></td>
                        {{-- <td><center>{{ $lesson->quota }}</center></td> --}}
                        <td><center>{!! $status !!}</center></td>
                        <td><center>
                            @if ($showEnrollButton && !($hideButton))
                                <a class="" data-toggle="tooltip" data-placement="top" title="Click to enroll" 
                                href="{{ route('lessons.enroll', $lesson->id) }}"><img src="/img/add.png" alt="enroll"></a>
                            @elseif ($showCancelButton && !($hideButton))
                                <a class="" data-toggle="tooltip" data-placement="top" title="Click to cancel enrollment" href="{{ route('lessons.cancel', $lesson->id) }}"><img src="/img/remove.png" alt="enroll"></a>
                            @elseif ($showCancelButton && $hideButton)
                                Enrolled
                            @endif
                            @if (Helper::admin())
                                <a class="" href="{{ route('lessons.edit', $lesson->id) }}">
                                    <img src="/img/edit.png" alt="edit">
                                </a>
                            @endif

                        </center></td>                            
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endempty {{-- @empty($lesson) --}}


@endsection