<div class="modal fade" tabindex="-1" role="dialog" id="gitLabAccount">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ action('ProfileController@gitLabAccount') }}">
                {{ csrf_field() }}
                <input type="hidden" name='type' id='type'>
                <input type="hidden" name="new" value="false">

                <div class="modal-header">
                    <h5 class="modal-title">Please enter your current password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>          {{-- end of modal-header --}}

                <div class="modal-body">
                    <div class="form-group">
{{--                         <label class="col-form-label form-label" for="filename">Filename:</label>
 --}}
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="form-help">GitLab will use the same password initially.</span>
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
    $(document).on("click", "#gitLabAccountModal", function () {
        var type = $(this).data('type');
        $(".modal-content #type").val(type);
    });
</script>