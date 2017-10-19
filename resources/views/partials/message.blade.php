{{-- AT-Pending: show warning if being impersonates  --}}
@if ($flash = session('message'))
    @if (!($alertType = session('messageAlertType')))
        @php
            $alertType = 'alert-info';
        @endphp
    @endif
    <div class="form-group">
        <div id="flash-message" class="alert {{ $alertType }} " role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ $flash }}
        </div>
    </div>
@endif