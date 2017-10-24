{{-- AT-Pending: show warning if being impersonates  --}}
@if ($flash = session('message'))
    @if (!($alertType = session('messageAlertType')) 
    || !in_array($alertType, ['alert-primary', 'alert-secondary', 'alert-success', 'alert-danger', 'alert-warning', 'alert-info', 'alert-light', 'alert-dark']) )
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