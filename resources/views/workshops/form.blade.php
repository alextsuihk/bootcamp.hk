@include ('partials.errors')

<form method="POST" action="{{ $action }}" >
    {{ csrf_field() }}
    {{ $method }}       {{-- needed in case of update [PATCH] which is not supported by most browsers today --}}

    <div class="form-group">
        <label for="title">Course Number:</label>
        <input type="number" class="form-control" id="number" name="number" 
        value="{{ Helper::old('number', $edit) }}" required placeholder="101">
    </div>

    <div class="form-group">
        <label for="title">Title:</label>
        <input class="form-control" id="title" name="title" 
        value="{{ Helper::old('title', $edit) }}" required></textarea>
    </div>

    <div class="form-group">
        <label for="abstract">Abstract: (use TinyMCE)</label>
        <textarea class="form-control" id="abstract" name="abstract" rows="15" 
        required>{{ Helper::old('abstract', $edit) }}</textarea>
    </div>

    <div class="form-group">
        <label class="mr-sm-2" for="level_id">Difficulty Level: </label>
        <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="level_id" name="level_id">
            <option selected>Choose...</option>
            @foreach ($levels as $level)
                <option <?php if ($level->id == Helper::old('level_id', $edit)) { echo "selected";} ?>
                 value="{{ $level->id }}">{{ $level->difficulty }}</option>
            @endforeach
            </select>
    </div>

    <div class="form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="is_active" {{ Helper::old('is_active', $edit) ? 'checked' : '' }}> Active (course will be visible to usesr) </label>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button }}</button>

        <a class="btn btn-secondary" href="{{ route('workshops.index') }}">Cancel</a>
    </div>

</form>