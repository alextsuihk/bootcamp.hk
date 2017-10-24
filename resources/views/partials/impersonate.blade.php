@if (request()->session()->has('impersonate'))
    <div class="form-group">
        <div class="alert alert-info" role="alert">
            impersonsated as {{ $impersonate}}  stop impersonate
        </div>
    </div>
@endif