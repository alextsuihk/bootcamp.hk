@if (count($questions) == 0)
    <div class="jumbotron">
        There is no question
    </div>
@else

    <div class="table-responsive">
        <table class="table" sytle="border:none;">
{{--                 <thead>
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead> --}}
            <tbody>
                @foreach ($questions as $question)
                    @php
                        if ($question->blacklisted == true) {
                            $blacklisted = "[Blacklisted]<br>";
                        } else {
                            $blacklisted = '';
                        }
                        $last_modified = ($question->last_modified_at); 
                        /* how to show question submitter name, either: me, show, or anonymous */
                        if ($question->last_modified_by->id == Auth::id()) {
                            $username = 'me';
                        } elseif ($question->last_modified_by->anonymous) { 
                            $username = ' user **'.substr($question->last_modified_by->id, -2);
                        } else {
                            $username = $question->last_modified_by->name;
                        }

                        /* determine number of newly comment (if user is the question submitter */
                        if (Auth::id() == $question->user_id)
                        {
                            $newlyComments = 0;
                            foreach ($question->comments as $comment) {
                                if ($comment->viewed == false) {
                                    $newlyComments++;
                                }
                            }
                            if ($newlyComments > 0 ) {
                                $update = $newlyComments.' '.str_plural('update', count($newlyComments))."<br>";
                            } else {
                                $update = '';
                            } 
                        } else {
                            $update = '';
                        }

                    @endphp

                    <tr>
                        <td rowspan="2" colspan="1" style="vertical-align: middle;"><center>
                            {!! $blacklisted !!}
                            {!! $update !!}
                            {{ count($question->comments) }}
                            {{ str_plural('comment', count($question->comments)) }}
                         </center></td>

                        <td rowspan="1" colspan="2">
                            @if ($question->blacklisted == true)
                                <strong><h4><span style="text-decoration:line-through;">{{ $question->title }}</span></h4></strong></a>
                            @else
                                <a href="{{ route('questions.show', [$question->id, str_slug($question->title)]) }}"><strong><h4>{{ $question->title }}</h4></strong></a>
                            @endif
                        </td>
                        <td></td>
{{--                         <td rowspan="2" colspan="1" style="vertical-align: middle;">
                            <a class="btn btn-warning" href="{{route('questions.complain', $question->id)}}">
                                    Complain</a>
                            @if (Helper::admin())
                                <a class="btn btn-danger" href="{{route('questions.blacklist', $question->id)}}">
                                    Blacklist</a>
                            @endif
                        </td> --}}
                    </tr>
                    <tr>
                            <td class="text-left">
                                {{-- AT-Pending: future tags go here --}}
                            </td>
                            <td class="text-right">modified {{ $last_modified->diffForHumans() }} <br>by {{ $username }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endempty {{-- @empty($courses) --}}