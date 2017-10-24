<form method="POST" action="{{ $action }}" >
    {{ csrf_field() }}

    <div class="form-group">
        <label class="col-md-4 control-label form-label" for="name">Username:</label>
        <input type="text" class="form-control col-md-6" id="name" name="name" 
        value="{{ $user->name }}" disabled>
        <span class="form-help">cannot change username, it is also used in gitlab</span>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label form-label" for="nickname">Nickame:</label>
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
        <label class="col-md-4 control-label form-label" for="email">Email:
        @if (Auth::user()->email_verified)
            <span class="badge badge-success">verified</span>
        @else
            <div><a class="btn btn-primary" href="{{ route('email.sendverify') }}">Resend Verification Email</a></div>
        @endif
        </label>
        <input type="email" class="form-control col-md-6" id="email" name="email" 
        value="{{ $user->email }}" disabled>
{{--         <input type="email" class="form-control" id="email" name="email" 
        value="{{ Helper::old('email', $user) }}"  disabled}>
 --}}        
        <span class="form-help">If you wish to change email, pls send email to admin@bootcamp.hk</span>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label form-label" for="mobile">Mobile:</label>
        <input type="number" class="form-control col-md-6" id="mobile" name="mobile" 
        value="{{ Helper::old('mobile', $user) }}"  {{ $disabled }}>
        @if ($errors->has('mobile'))
            <div class="form-error">
                <strong>{{ $errors->first('mobile') }}</strong>
            </div>
        @endif
        <span class="form-help">format: 91234567</span>
    </div>


{{--     <div class="form-group">
        <div class="checkbox-inline">
            <label>
                <input type="checkbox" name="is_active" {{ Helper::old('is_active', $user) ? 'checked' : '' }} 
                {{ $disabled }}> Active for Enrollment </label>
                <span class="form-help">course will be visible to usesr</span>
        </div>
    </div> --}}

    @if ($type == 'show')
        <div class="form-group">
            <a class="btn btn-primary" href="{{ route('profile.edit') }}">Return</a>
        </div>
    @else
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
            <a class="btn btn-secondary" href="{{ route('home') }}">Cancel</a>
        </div>
    @endif

</form>