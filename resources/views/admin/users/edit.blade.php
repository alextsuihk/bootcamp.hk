@extends ('layouts.master')

@section ('title', 'Update Profile')

@section ('content')
    <h2>Update User Profile (Admin)</h2>
    <hr>

    @include ('admin.users.statistic')

    <form method="POST" action="{{ action('Admin\UserController@update', $user->id) }}" >
        {{ csrf_field() }}
        
        <div class="form-group">
            <label class="col-md-5 control-label form-label" for="name">Username:</label>
            <input type="text" class="form-control col-md-6" id="name" name="name" 
            value="{{ Helper::old('name', $user) }}" >
            <span class="form-help">cannot change username, it is also used in gitlab</span>
        </div>

        <div class="form-group">
            <label class="col-md-5 control-label form-label" for="nickname">Nickame:</label>
            <input type="text" class="form-control col-md-6" id="nickname" name="nickname" 
            value="{{ Helper::old('nickname', $user) }}" required>
            @if ($errors->has('nickname'))
                <div class="form-error">
                    <strong>{{ $errors->first('nickname') }}</strong>
                </div>
            @endif
            <span class="form-help">e.g. Super Man, Fast Learner, 小強</span>
        </div>

        <div class="form-group">
            <label class="col-md-5 control-label form-label" for="email">Email:
            @if (Auth::user()->email_verified)
                <span class="badge badge-success">verified</span>
            @else
                <div><a class="btn btn-primary" href="{{ route('email.sendverify') }}">Resend Verification Email</a></div>
            @endif
            </label>
            <input type="email" class="form-control col-md-6" id="email" name="email" 
            value="{{ Helper::old('email', $user) }}">
            <span class="form-help">If you wish to change email, pls send email to {{ config('mail.admin_email') }}</span>
        </div>

        <div class="form-group">
            <label class="col-md-5 control-label form-label" for="mobile">Mobile:</label>
            <input type="number" class="form-control col-md-6" id="mobile" name="mobile" 
            value="{{ Helper::old('mobile', $user) }}">
            @if ($errors->has('mobile'))
                <div class="form-error">
                    <strong>{{ $errors->first('mobile') }}</strong>
                </div>
            @endif
            <span class="form-help">(optional field) format: 91234567</span>
        </div>

{{--         <div class="form-group">
            <p class="col-md-5 control-label form-label">Your account is linked with:
                @if ($user->facebook_id)
                    <a href="{{ route('profile.detach', 'Facebook') }}" title="unlink Facebook login">
                        <img src="/img/facebook.png"></a>
                @endif

                @if ($user->linkedin_id)
                    <a href="{{ route('profile.detach', 'LinkedIn') }}" title="unlink LinkedIn login">
                        <img src="/img/linkedin.png"></a>
                @endif
            </p>
        </div> --}}

        <div class="form-group">
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" name="disabled" {{ Helper::old('disabled', $user) ? 'checked' : '' }}> Disable this user</label>
                    @if ($errors->has('disabled'))
                        <div class="form-error">
                            <strong>{{ $errors->first('disabled') }}</strong>
                        </div>
                    @endif
                    <div class="form-help">Disable this user login, kick him out immediately</div>

            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a class="btn btn-secondary" href="{{ route('admin.users.index') }}">Cancel</a>
        </div>

    </form>














@endsection


