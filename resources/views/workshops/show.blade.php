@extends ('layouts.master')

@section ('title', 'Workshop Detail')

@section ('content')

    @empty($workshop)
        This is no such workshop, please check, email to 
        <a href="mailto:{{ config('mail.admin_email') }}">{{ config('mail.admin_email') }} </a>

    @else
        <h2>Workshop Detail</h2>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <h3>{{ $workshop->title }}</h3>
                  
                <a class="btn btn-primary" href="/workshops/{{ $workshop->id }}">View Detail</a>
                <a class="btn btn-primary" href="/favorites/{{ $workshop->id }}">Interested</a>
                <a class="btn btn-primary" href="/workshops/{{ $workshop->id }}">Admin Edit</a>

                <p>Level:{{ $workshop->level->difficulty }}</p>
                <p>
                    Abstract:
                    {{ $workshop->abstract }}
                </p>
            </thead>
            </table>
        </div>

        Show Class Info & Schedle in table format .....

        @empty($workshop->lessons)
            This is NO lessons schedule

        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        
                    </thead>
                    <tbody>
                        @foreach ($workshop->lessons as $lesson)
                            <tr>
                                <td><a href="/workshops/{{ $lesson->id }}">{{ $lesson->number }}</a></td>
                                <td>{{ $lesson->instructor }}</td>
                                <td>{{ $lesson->venue }}</td>
                                <td>{{ $lesson->first_day }}</td>
                                <td>{{ $lesson->last_day }}</td>
                                <td>{{ $lesson->schedule }}</td>

          
                                <td><a class="btn btn-primary" href="/workshop/{{ $workshop->id }}lessons/{{ $lesson->id }}">Enroll</a></td>
                                <td><a class="btn btn-primary" href="/workshop/{{ $workshop->id }}lessons/{{ $lesson->id }}">Edit (Admin)</a></td>
                                <td>Total Enroll</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endempty   {{-- @empty($workshop->lessons) --}}

    @endempty  {{-- @empty($workshop) --}}


    @include ('partials.footer')

@endsection