<div class="modal fade" tabindex="-1" role="dialog" id="askQuestion">
    <div class="modal-dialog modal-lg" role="document"  sytle="height:800px;">
        <div class="modal-content">
            <form method="POST" action="{{ action('QuestionController@store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{-- <input type="hidden" name="course_number" value="{{ $course->number }}">  --}}
                <input type="hidden" name='course_id' id='course_id'>

                <div class="modal-header">
                    <h5 class="modal-title">Posting Question</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>          {{-- end of modal-header --}}

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label form-label" for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" rquired>
                        @if ($errors->has('title'))
                            <div class="form-error">
                                <strong>{{ $errors->first('title') }}</strong>
                            </div>
                        @endif
                        <span class="form-help">Please be short and precise </span>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label form-label" for="body">Body:</label>
                        <textarea class="mceEditable form-control" id="body" name="body" rows="15" required>
                            {!! old('body') !!}
                        </textarea>
                        @if ($errors->has('body'))
                            <div class="form-error">
                                <strong>{{ $errors->first('body') }}</strong>
                            </div>
                        @endif
                        <span class="form-help">You coud copy &amp; paste screen-capture, and please use "Insert -> Code Sample" for entering codes</span>
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>          {{-- end of modal-body --}}
            </form>             {{-- end of form --}}
        </div>                  {{-- end of modal-content --}}
    </div>                      {{-- end of modal-dialog --}}
</div>                          {{-- end of modal --}}


<script>
    $(document).on("click", "#askQuestionModal", function () {
        var id = $(this).data('course_id');
        $(".modal-content #course_id").val(id);
    });
</script>