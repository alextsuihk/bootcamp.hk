@extends ('layouts.master')

@section ('title', 'Questions')


@section ('content')

@php
    if ($question->user->id == Auth::id()) {
        $username = 'me';
    } elseif ($question->user->anonymous) { 
        $username = ' user **'.substr($question->user->id, -2);
    } else {
        $username = $question->user->name;
    }
@endphp
<p><a href="{{ url()->previous() }}" class="btn btn-success">Return to Previous Page</a></p>

<div class="jumbotron ">
    <span class="row">
        <span class="mr-auto ml-2">
            <h2>{{ $question->title }}</h2>
        </span>
        <span  class="ml-auto mr-3">
            {{ $question->created_at->diffForHumans() }} ,modified by {{ $username }}
        </span>
    </span>
    
    <div class="form-control mceNonEditable" style="background-color: white;">
        {!! $question->body !!}</div>

    @if ($question->course_id > 0)
    <p>
        This question is linked to Course# <a href="{{ route('courses.show', $question->course->number) }}">
            {{ $question->course->number }} : {{ $question->course->title }}<a>
    </p>
    @endif

    @if (Helper::admin())
        <p>
            <div class="btn-group" role="group">
                <a href="{{ route('questions.voteadmin', [$question->id, 'close']) }}" 
                    class="btn btn-warning">Close</a>
                <a href="{{ route('questions.voteadmin', [$question->id, 'blacklist']) }}" 
                    class="btn btn-danger">Backlist</a>
            </div>
        </p>
    @endif
</div>

<hr>

@forelse ($question->comments as $comment)
    @php
        if ($comment->user->id == Auth::id()) {
            $commenter = 'me';
        } elseif ($comment->user->anonymous) { 
            $commenter = ' user **'.substr($comment->user->id, -2);
        } else {
            $commenter = $comment->user->name;
        }
    @endphp

    <p>
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">{{ $comment->created_at->diffForHumans() }}, commented by {{ $commenter }}</h6>
        <p class="card-text">
                <div class="form-control mceNonEditable" style="background-color:  #e9ecef;">
                {!! $comment->body !!}</div>
        </p>
        @if (Helper::admin())
            <div class="btn-group" role="group">
                <a href="#" class="btn btn-success" title="update table comments">Correct</a>
                <a href="#" class="btn btn-warning" title="update table comments">Wrong</a>
                <a href="#" class="btn btn-danger" title="">Backlist</a>
            </div>
        @elseif (Auth::check())
        {{-- AT-Pending: create pivot  comment_user: user_id, comment_id, vote=correct/wrong/complain --}}
{{--             <div class="btn-group" role="group">
                <a href="#" class="btn btn-success" title="Agree with the comment">Agree</a>
                <a href="#" class="btn btn-warning" title="Disagree with the commment">Disgree</a>
                <a href="#" class="btn btn-danger" title="report abuse">Complain</a>
            </div> --}}
        @endif
      </div>
    </div>
    </p>

@empty
    <div class="jumbotron ">
        No one has commented on this question
    </div>

@endforelse

<hr>

<form method="POST" action="{{ action('CommentController@store') }}" >
    {{ csrf_field() }}
    <input type="hidden" name="question_id" value="{{ $question->id }}" />
    <div class="form-group">
        <label class="col-form-label form-label" for="body">New Comment:</label>

        <textarea class="mceEditable form-control" id="body" name="body" rows="15"></textarea>
        @if ($errors->has('body'))
            <div class="form-error">
                <strong>{{ $errors->first('abstract') }}</strong>
            </div>
        @endif
        <span class="form-help">TinyMCE supports photo copy &amp; paste</span>
    </div>
    <button type="submit" class="btn btn-primary">Post Your Comment</button>
</form>

  
@endsection