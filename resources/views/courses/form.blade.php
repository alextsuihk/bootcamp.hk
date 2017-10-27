<form method="POST" action="{{ $action }}" >
    {{ csrf_field() }}
    {{ $method }}       {{-- needed in case of update [PATCH] which is not supported by most browsers today --}}
                        {{-- we also add a custom helper in \app\Helpers\Helper.php  --}}

{{-- AT-Pending: no need to pass course->id,we are using course-number as reference
    <input type="hidden" name="course_id" value="{{ $course->id }}" /> --}}
    <div class="form-group">
        <label class="col-form-label form-label" for="title">Course Number:</label>
        <input type="number" class="col-1 form-control" id="number" name="number" 
        value="{{ Helper::old('number', $edit) }}" placeholder="101" 
        required {{ $disabled }} {{ $course_num_readonly }}>
        @if ($type != 'show')
            @if ($errors->has('number'))
                <div class="form-error">
                    <strong>{{ $errors->first('number') }}</strong>
                </div>
            @endif
            <span class="form-help">A 3-digit course number. Cannot be changed after creation.
            </span>
        @endif
    </div>

    <div class="form-group">
        <label class="col-form-label form-label" for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" 
        value="{{ Helper::old('title', $edit) }}" required {{ $disabled }}>
        @if ($type != 'show')
            @if ($errors->has('title'))
                <div class="form-error">
                    <strong>{{ $errors->first('title') }}</strong>
                </div>
            @endif
            <span class="form-help">Title could be used in search</span>
        @endif
    </div>

    @if ($type == 'show')
        <div class="form-group">
            <label class="col-form-label form-label" for="title">Level of Difficulty:</label>
            <input type="text" class="form-control" value="{{ $edit->level->difficulty }}" {{ $disabled }}>

        </div>
        <div class="form-group">
            <label class="col-form-label form-label" for="abstract">Abstract:</label>
            <div class="form-control" style="background-color: #e9ecef;"> {!! $edit->abstract !!} </div>
        </div>
    @else
        <div class="form-group">
            <label class="col-form-label form-label" for="level_id">Difficulty Level: </label>
            <select class="form-control custom-select " id="level_id" name="level_id">
                <option selected>Choose...</option>
                @foreach ($levels as $level)
                    <option <?php if ($level->id == Helper::old('level_id', $edit)) { echo "selected";} ?>
                     value="{{ $level->id }}">{{ $level->difficulty }}</option>
                @endforeach
                </select>
                @if ($errors->has('level_id'))
                    <div class="form-error">
                        <strong>{{ $errors->first('level_id') }}</strong>
                    </div>
                @endif
                <span class="form-help">how difficult is this course</span>
        </div>
        <div class="form-group">
            <label class="col-form-label form-label" for="abstract">Abstract: (use TinyMCE)</label>
            <textarea class="form-control" id="abstract" name="abstract" rows="15" 
            required>{!! Helper::old('abstract', $edit) !!}</textarea>
            @if ($errors->has('abstract'))
                <div class="form-error">
                    <strong>{{ $errors->first('abstract') }}</strong>
                </div>
            @endif
            <span class="form-help">use html format</span>
        </div>
    @endif

    <div class="form-group">
        <div class="checkbox-inline">
            <label>
                <input type="checkbox" name="is_active" {{ Helper::old('is_active', $edit) ? 'checked' : '' }} 
                {{ $disabled }}> Active for user viewing </label>
            @if ($type != 'show')
                @if ($errors->has('is_active'))
                    <div class="form-error">
                        <strong>{{ $errors->first('is_active') }}</strong>
                    </div>
                @endif
                <div class="form-help">course will be visible to usesr</div>
            @endif
        </div>
    </div>

    @if (Helper::admin()) 
        <div class="form-group">
            <label class="col-form-label form-label" for="remark">Remark (admin):</label>
            @if ($type == 'show')
            <div class="form-control" style="background-color: #e9ecef;"> {!! $edit->remark !!} </div>
            @else
                <textarea class="form-control" id="remark" name="remark" rows="3">{!! Helper::old('remark', $edit) !!}</textarea>
                @if ($errors->has('remark'))
                    <div class="form-error">
                        <strong>{{ $errors->first('remark') }}</strong>
                    </div>
                @endif
                <span class="form-help">Admin Note</span>
            @endif
        </div>
    @endif 

    <div class="form-group">
        @if ($type == 'show')
            <a class="btn btn-primary" href="{{ route('courses.index') }}">Home</a>
            <a class="" href="/course/{{ $course->number }}/like"><img src="/img/thumbs-up.png" alt="like"></a>
            <a class="btn btn-primary" href="/course/{{ $course->number }}/follow">Follow</a>
        @else
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
            <a class="btn btn-secondary" href="{{ route('courses.index') }}">Cancel</a>
        @endif
    </div>

    <br>

</form>