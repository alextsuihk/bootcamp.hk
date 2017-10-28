@component('mail::message')

Hello, {{ $user->nickname }}

Please click the Button below to verify your email address.<br>
Token will expire in {{ $expireInMinutes }} minutes.

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

Thank you

@component('mail::subcopy')
If you’re having trouble clicking the "Verify Email" button, copy and paste the URL below
into your web browser: [{{ $url }}]({{ $url }})
@endcomponent

{{-- Regards,<br>{{ config('app.name') }} --}}

@endcomponent
