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

<div class="card-body">
    <span class="row">
        <span class="mr-auto ml-2">
            <h5>{{ $question->title }}</h5>
        </span>
        <span  class="ml-auto mr-3"><small>
            {{ $question->created_at->diffForHumans() }} ,modified by {{ $username }}
        </small></span>
    </span>
    
    <div class="form-control mceNonEditable" style="background-color: white;">
        {!! $question->body !!}</div>

    @if ($question->course_id > 0)
    <p>
        This question is linked to Course# <a href="{{ route('courses.show', $question->course->number) }}">
            {{ $question->course->number }} : {{ $question->course->title }}
    </p>
    @endif


    @if (Helper::admin())
        <p>
            <div class="btn-group" role="group">
                <a href="{{ route('questions.voteadmin', [$question->id, 'close']) }}" 
                    class="btn btn-sm btn-warning">Close</a>
                <a href="{{ route('questions.voteadmin', [$question->id, 'blacklist']) }}" 
                    class="btn btn-sm btn-danger">Backlist</a>
            </div>
        </p>
    @endif
</div>

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

    <div class="card-body">
        <span class="row">
            <span  class="ml-auto mr-3"><small>
                {{ $comment->created_at->diffForHumans() }}, commented by {{ $commenter }}
            </small></span>
        </span>

        <div class="form-control mceNonEditable" style="background-color:  #e9ecef;">
        {!! $comment->body !!}</div>

        @if (Helper::admin())
            <p>
                <div class="btn-group" role="group">
                    <a href="#" class="btn btn-sm btn-success" title="update table comments">Correct</a>
                    <a href="#" class="btn btn-sm btn-warning" title="update table comments">Wrong</a>
                    <a href="#" class="btn btn-sm btn-danger" title="">Backlist</a>
                </div>
            </p>
        @elseif (Auth::check())
        {{-- AT-Pending: create pivot  comment_user: user_id, comment_id, vote=correct/wrong/complain --}}
{{--             <div class="btn-group" role="group">
                <a href="#" class="btn btn-success" title="Agree with the comment">Agree</a>
                <a href="#" class="btn btn-warning" title="Disagree with the commment">Disgree</a>
                <a href="#" class="btn btn-danger" title="report abuse">Complain</a>
            </div> --}}
        @endif
      </div>

@empty          {{-- else of @forelse --}}
    <div class="card-body">
        <div class="form-control mceNonEditable" style="background-color:  #e9ecef;">
        No one has commented on this question</div>
    </div>

@endforelse     {{-- end of @forelse --}}

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
        <span class="form-help">You coud copy &amp; paste screen-capture, and please use "Insert -> Code Sample" for entering codes</span>
    </div>
    <button type="submit" class="btn btn-primary">Post Your Comment</button>
</form>

  
@endsection