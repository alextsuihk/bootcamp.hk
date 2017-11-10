<form method="POST" action="{{ $action }}" >
    {{ csrf_field() }}
    {{ $method }}       {{-- needed in case of update [PATCH] which is not supported by most browsers today --}}
                        {{-- we also add a custom helper in \app\Helpers\Helper.php  --}}

    <input type="hidden" name="course_id" value="{{ $course->id }}" />
    @if ($type != 'create')
        <div class="form-group">
            <label class="col-form-label form-label" for="sequence">Seq Number:</label>
            <input type="number" class="form-control" id="sequence" name="sequence" 
            value="{{ $edit->sequence }}" disabled >
        </div>
    @endif

    <div class="form-group">
        <label class="col-form-label form-label" for="venue">Venue:</label>
        <input type="text" class="form-control" id="venue" name="venue" 
        value="{{ Helper::old('venue', $edit) }}" {{ $disabled }}>
        @if ($type != 'show')
            @if ($errors->has('venue'))
                <div class="form-error">
                    <strong>{{ $errors->first('venue') }}</strong>
                </div>
            @endif
            <span class="form-help">Class Location</span>
        @endif
    </div>

    <div class="form-group">
        <label class="col-form-label form-label" for="instructor">Host:</label>
        <input type="text" class="form-control" id="instructor" name="instructor" 
        value="{{ Helper::old('instructor', $edit) }}" {{ $disabled }}>
        @if ($type != 'show')
            @if ($errors->has('instructor'))
                <div class="form-error">
                    <strong>{{ $errors->first('instructor') }}</strong>
                </div>
            @endif
            <span class="form-help">Host name</span>
        @endif
    </div>

    @if ($type == 'show')
        <div class="form-group">
            <label class="col-form-label form-label" for="title">Teaching Language:</label>
            <input type="text" class="col-4 form-control" value="{{ $edit->teaching_language }}" {{ $disabled }}>

        </div>
    @else
        <div class="form-group">
            <label class="col-form-label form-label" for="teaching_language_id">Teaching Language:</label>
            <select class="form-control custom-select " id="teaching_language_id" name="teaching_language_id">
                <option selected>Choose...</option>
                @foreach ($teaching_languages as $teaching_language)
                    <option <?php if ($teaching_language->id == Helper::old('teaching_language_id', $edit)) 
                    { echo "selected";} ?>
                     value="{{ $teaching_language->id }}">{{ $teaching_language->language }}</option>
                @endforeach
                </select>
                @if ($errors->has('teaching_language_id'))
                    <div class="form-error">
                        <strong>{{ $errors->first('teaching_language_id') }}</strong>
                    </div>
                @endif
                <span class="form-help">Language being used</span>
        </div>
    @endif

    <div class="form-group">
        <label class="col-form-label form-label" for="first_day">First Day:</label>
        <div class="input-group date">
            <input type="text" class="col-2 form-control" id="first_day" name="first_day" placeholder="YYYY-MM-DD" value="{{ Helper::old('first_day', $edit) }}">
        </div>
        <script type="text/javascript">
            $('#first_day').datepicker({
                format: 'yyyy-mm-dd'
            });
        </script>
    </div>

    <div class="form-group">
        <label class="col-form-label form-label" for="last_day">Last Day:</label>
        <div class="input-group date">
            <input type="text" class="col-2 form-control" id="last_day" name="last_day" placeholder="YYYY-MM-DD" value="{{ Helper::old('last_day', $edit) }}">
        </div>
        <script type="text/javascript">
            $('#last_day').datepicker({
                format: 'yyyy-mm-dd'
            });
        </script>
    </div>

    <div class="form-group">
        <label class="col-form-label form-label" for="schedule">Schedule:</label>
        <input type="text" class="form-control" id="schedule" name="schedule" 
        value="{{ Helper::old('schedule', $edit) }}" {{ $disabled }}>
        @if ($type != 'show')
            @if ($errors->has('schedule'))
                <div class="form-error">
                    <strong>{{ $errors->first('schedule') }}</strong>
                </div>
            @endif
            <span class="form-help">e.g. Every Mon 6~8pm</span>
        @endif
    </div>

    <div class="form-group">
        <label class="col-form-label form-label" for="quota">Quota:</label>
        <input type="number" class="col-1 form-control" id="quota" name="quota" 
        value="{{ Helper::old('quota', $edit) }}" {{ $disabled }}>
        @if ($type != 'show')
            @if ($errors->has('quota'))
                <div class="form-error">
                    <strong>{{ $errors->first('quota') }}</strong>
                </div>
            @endif
            <span class="form-help">Class Location</span>
        @endif
    </div>

    <div class="form-group">
        <div class="checkbox-inline">
            <label>
                <input type="checkbox" name="active" {{ Helper::old('active', $edit) ? 'checked' : '' }} 
                {{ $disabled }}> Active for Enrollment </label>
            @if ($type != 'show')
                @if ($errors->has('active'))
                    <div class="form-error">
                        <strong>{{ $errors->first('active') }}</strong>
                    </div>
                @endif
                <div class="form-help">course will be visible to user</div>
            @endif
        </div>
    </div>

    @if (Helper::admin()) 
        <div class="form-group">
            <label class="col-form-label form-label" for="remark">Remark (admin):</label>
            @if ($type == 'show')
            <div class="form-control" style="background-color: #e9ecef;"> {!! $edit->remark !!} </div>
            @else
                <textarea class="mceEditable form-control" id="remark" name="remark" rows="3">
                {!! Helper::old('remark', $edit) !!}</textarea>
                @if ($errors->has('remark'))
                    <div class="form-error">
                        <strong>{{ $errors->first('remark') }}</strong>
                    </div>
                @endif
                <span class="form-help">Admin Note</span>
            @endif
        </div>
        
        <div class="form-group">
            <div class="checkbox-inline">
                <label>
                    <input type="checkbox" name="deleted" {{ Helper::old('deleted', $edit) ? 'checked' : '' }} 
                    {{ $disabled }}> Deleted this course (hidden from all access) </label>
                    @if ($type != 'show')
                        @if ($errors->has('deleted'))
                            <div class="form-error">
                                <strong>{{ $errors->first('deleted') }}</strong>
                            </div>
                        @endif
                        <div class="form-help">hidden from all access</div>
                    @endif
            </div>
        </div>
    @endif 

    <div class="form-group">
        <button type="submit" class="btn btn-primary">{{ $button }}</button>
        <a class="btn btn-secondary" href="{{ $previousUrl }}">Cancel</a>
    </div>

    <br>

</form>

