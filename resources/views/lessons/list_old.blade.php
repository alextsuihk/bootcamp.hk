@if (!($course->active) && !Helper::admin())
    <div class="jumbotron">
        Course is not active, lesson information will NOT be shown<br>
        Please contact system administrator !
    </div>
@elseif (count($lessons) == 0)
    <div class="jumbotron">
        No Class Offering at the moment
    </div>
@else   
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><center>No.</center></th>
                    <th><center>Venue</center></th>
                    <th><center>Host</center></th>
                    <th><center>Language</center></th>
                    <th><center>Schedule</center></th>
                    {{-- <th><center>Quota</center></th> --}}
                    <th><center>Status</center></th>
                    <th><center>Enroll</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lessons as $lesson)

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

                    @if (Auth::check() && $lesson->users->keyBy('id')->contains(Auth::id()))
                        <?php $showCancelButton = true; ?>             {{-- if logged-in && enrolled --}}
                        <?php $showEnrollButton = false; ?>

                        <?php $enrolled_at = $lesson->users->where('id', Auth::id())->pluck('enrolled_at'); ?>
                        <?php $position = $lesson->users->where('enrolled_at', '<=', $enrolled_at)->count(); ?>

                        @if ($position > $lesson->quota)
                            <?php $status = $status.'<br>waitlisted(#'. ($position - $lesson->quota) .')'; ?>
                        @else
                            <?php $status = $status.'<br>enrolled'; ?>
                        @endif

                    @else
                        <?php $showEnrollButton = true; ?>             {{-- if NOT logged-in || NOT enrolled --}}
                        <?php $showCancelButton = false; ?>
                    @endif

                    <tr>
                        <td><center>{{ $lesson->course->number }}-{{ sprintf('%02d', $lesson->sequence) }}</center></td>
                        <td><center>
                            @if ($lesson->venue)
                                <span data-toggle="tooltip" data-placement="top" title="{{ $lesson->venue }}">
                                {{ str_limit($lesson->venue, 50, ' ...') }}</span>
                            @else
                                (TBD)
                            @endif
                        </center></td>
                        <td><center>
                            @if ($lesson->instructor)
                                {{ $lesson->instructor }}
                            @else
                                (TBD)
                            @endif
                        </center></td>
                        <td><center>{{ $lesson->teaching_language->language }}</center></td>
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

@endempty {{-- @empty($courses) --}}
