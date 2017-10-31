<div class="modal fade" tabindex="-1" role="dialog" id="uploadNew">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ action('AttachmentController@store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="course_number" value="{{ $course->number }}">
                <input type="hidden" name="new" value="true">

                <div class="modal-header">
                    <h5 class="modal-title">Upload a New File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>          {{-- end of modal-header --}}

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label form-label" for="attachment">Attachment:</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label form-label" for="filename">Filename:</label>
                        <input type="text" class="form-control" id="filename" name="filename">
                        <span class="form-help">(optional) if blank, will use the original filename</span>

                    </div>

                    <div class="form-group">
                        <label class="col-form-label form-label" for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description">
                        <span class="form-help">(optional) a short description</span>

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

<div class="modal fade" tabindex="-1" role="dialog" id="appendMore">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ action('AttachmentController@store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="course_number" value="{{ $course->number }}">
                <input type="hidden" name='attachment_id' id='attachment_id'>
                <input type="hidden" name="new" value="false">

                <div class="modal-header">
                    <h5 class="modal-title">Upload a revision</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>          {{-- end of modal-header --}}

                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label form-label" for="attachment">Attachment:</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
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
    $(document).on("click", "#appendMoreModal", function () {
        var id = $(this).data('id');
        $(".modal-content #attachment_id").val(id);
    });
</script>