@if (!($course->active) && !Helper::admin())
    <div class="jumbotron">
        Course is not active, file attachments will NOT be shown<br>
        Please contact system administrator !
    </div>
@elseif (count($attachments) == 0)
    <div class="jumbotron">
        No file attachment for download
    </div>
@else   
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Description</th>
                    <th><center>Revision</center></th>
                    <th><center></center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attachments as $attachment)
                    <tr>
                        <td>{{ $attachment->filename }}</td>
                        <td>{{ $attachment->description }}</td>

                        <form method="POST" action="/attachments/download">
                            {{ csrf_field() }}
                            <td>
                                <select class="form-control custom-select" id="revision_id" name="revision_id">
                                    <option selected value="{{ $attachment->attachment_revisions->first()->id }}">Latest</option>
                                    @foreach ($attachment->attachment_revisions as $revision)
                                        <option value="{{ $revision->id }}">
                                            Rev: {{ $revision->revision }} &nbsp;&nbsp; 
                                            ({{ date_format($revision->created_at, 'Y-m-d') }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><center>
                                <button type="submit" class="btn btn-primary">Download</button>
                                @if (Helper::admin())
                                    <button id="appendMoreModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#appendMore" data-id="{{ $attachment->id }}">Update Revision</button>
                                    <a class="btn btn-secondary" href="/">Enable</a>
                                    <button type="submit" class="btn btn-primary">Enable</button>
                                    <button type="submit" class="btn btn-primary">Disable</button>
                                @endif
                            </center></td>
                        </form>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endempty {{-- @empty($courses) --}}
