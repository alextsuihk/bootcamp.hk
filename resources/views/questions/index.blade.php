@extends ('layouts.master')

@section ('title', 'Question Listing')

@section ('content')
    <h2>{{ $title }}</h2>
    <hr>

    <div class="row">
        <span class="mr-auto ml-3">
            <form method="GET" action={{ route('questions.index').'/'.$nav }} class="form-inline">
                <input class="form-control " type="search" id="keywords" name="keywords" placeholder="{{ $keywords }}" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </span>

        <span class="ml-auto mr-3">
            <a class="btn btn-info" href="{{ url()->current() }}">Clear Search</a>
            @if (Auth::id())
                <button id="askQuestionModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#askQuestion" data-course_id="0">Ask Question</button><br>
            @else
                <a class="btn btn-primary" href="{{ route("login") }}">Ask Question</a>
            @endif
        </span>
    </div>
        
    <br>

    {{-- creating a nav-tab --}}
    <div class="row">
        <span class="mr-auto ml-3">
            <?php $uri = route('questions.index'); ?>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <?php $active = ($nav=="allQuestions")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/allQuestions">All Questions</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="myQuestions")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/myQuestions">My Questions</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="myNewComments")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/myNewComments">My New Comments</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="unanswered")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/unanswered">Unanwersed Questions</a>
                </li>
                <li class="nav-item">
                    <?php $active = ($nav=="newQuestions")?"active":"";?>
                    <a class="nav-link {{ $active }}" href="{{ $uri }}/newQuestions">New Questions</a>
                </li>
                @if (Helper::admin())
                    <li class="nav-item">
                        <?php $active = ($nav=="openQuestions")?"active":"";?>
                        <a class="nav-link {{ $active }}" href="{{ $uri }}/openQuestions">Open Questions</a>
                    </li>
                @endif
            </ul>
        </span>
    </div>
    {{-- end of creating a nav-tab --}}

    @include ('questions.list')
    @include ('questions.modal')
@endsection