@if (Session::has('impersonate') && Session::get('impersonate') == Auth::id())
    <div class="form-group">
        <div class="alert alert-info" role="alert">
            <center><strong>Impersonsated as {{ Auth::user()->name }} 
                [{{ Auth::user()->nickname }}] ({{ Auth::id() }}) &nbsp;&nbsp;&nbsp;&nbsp; 
            <a href="{{ route('admin.users.stopImpersonate') }}">stop impersonate</a></strong></center>
        </div>
    </div>
@endif