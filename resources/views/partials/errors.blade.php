@if ($errors->any())
    <div class="form-group">
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <ul>{{ $error }}</ul>
                @endforeach
            </ul>
        </div>
    </div>
@endif