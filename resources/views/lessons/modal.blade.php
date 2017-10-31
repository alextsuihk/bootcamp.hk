AT-Pending: will work on it later, need to add more javascript


<div class="modal fade modal-lesson" tabindex="-1" role="dialog" id="addLesson">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="route('lessons.update')" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="course_number" value="{{ $course->number }}"

                <div class="modal-header">
                    <h5 class="modal-title">Title</h5>
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
        var title = $(this).data('title');
        var action = $(this).data('action');
        var method = $(this).data('method');
        $(".modal-content #title").val(title);
        $(".modal-content #action").val(action);
        $(".modal-content #method").val(method);
    });
</script>