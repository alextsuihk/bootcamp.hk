@extends ('layouts.master')

@section ('title', 'Change Password')

@section('content')
    <h2>Change Password</h2>
    <hr>

<form method="POST" action="/password/change" >
    {{ csrf_field() }}

    @if ($user->password)
        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label form-label">Current Password</label>

            <div class="col-md-6">
                <input id="old_password" type="password" class="form-control" name="old_password" required>

                @if ($errors->has('old_password'))
                    <span class="form-error">
                        <strong>{{ $errors->first('old_password') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    @endif

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label form-label">Password</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
                <span class="form-error">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label form-label">Confirm Password</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>
    </div>


    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a class="btn btn-secondary" href="{{ route('home') }}">Cancel</a>
    </div>


</form>

@endsection