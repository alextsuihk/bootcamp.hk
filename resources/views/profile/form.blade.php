@include ('partials.oauth2', ['title' => 'Link to OAuth2'])

<form method="POST" action="{{ $action }}" >
    {{ csrf_field() }}

    <div class="form-group">
        <label class="col-md-5 control-label form-label" for="name">Username:</label>
        <input type="text" class="form-control col-md-6" id="name" name="name" 
        value="{{ $user->name }}" disabled>
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
            <span><a class="btn btn-primary" href="{{ route('email.sendverify') }}">Resend Verification Email</a></span>
        @endif
        </label>
        <input type="email" class="form-control col-md-6" id="email" name="email" 
        value="{{ $user->email }}" disabled>
{{--         <input type="email" class="form-control" id="email" name="email" 
        value="{{ Helper::old('email', $user) }}"  disabled}>
 --}}        
        <span class="form-help">If you wish to change email, pls send email to {{ config('mail.admin_email') }}</span>
    </div>

    <div class="form-group">
        <label class="col-md-5 control-label form-label">GitLab:
        @if (Auth::user()->email_verified)
            @if (Auth::user()->gitlab_id == null)
                <button id="gitLabAccountModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#gitLabAccount" data-type="createGitLabAccount">Create</button>
            @else
                <span class="badge badge-success">GitLab account created</span>
                    <a href="https://gitlab.bootcamp.hk" target="_blank">https://gitlab.bootcamp.hk</a>
{{--                 <span><a class="btn btn-primary" title="Sync profile to GitLab "
                    href="#">Sync</a></span> --}}
            @endif 
        @else
            <span><button class="btn btn-primary", title="You need to verify email first" disabled>
                Create</button></span>
        @endif
        </label>
    </div>

    <div class="form-group">
        <label class="col-md-5 control-label form-label" for="mobile">Mobile:</label>
        <input type="number" class="form-control col-md-6" id="mobile" name="mobile" 
        value="{{ Helper::old('mobile', $user) }}"  {{ $disabled }}>
        @if ($errors->has('mobile'))
            <div class="form-error">
                <strong>{{ $errors->first('mobile') }}</strong>
            </div>
        @endif
        <span class="form-help">(optional field) format: 91234567</span>
    </div>

    <div class="form-group">
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
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
        <a class="btn btn-secondary" href="{{ route('home') }}">Cancel</a>
    </div>

</form>