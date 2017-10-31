@extends ('layouts.master')

@section ('title', 'Course Detail')

@section ('content')
    <h2>Email Verification Fail</h2>
    <hr>
    <div class="jumbotron form-error">
        <center>
            <h3>Verifciation Fails !!!</h3>
            @if ($result == 'nomatch')
                Please login and request email verification again
            @elseif ($result == 'expired')
                Token has expired. Please login and request email verification again
            @else
                Unknown Reason. Please login and request email verification again
            @endif
            <br><br>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">
            Resend Verification Email</a>
        </center>
    </div>
@endsection