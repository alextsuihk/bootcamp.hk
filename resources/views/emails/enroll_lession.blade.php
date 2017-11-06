@component('mail::message')

@isset($user->nickname)
    Hello, {{ $user->nickname }}
@else
    Hello, {{ $user->name }}
@endisset

You have sucessfully enrolled the following class
table


https://www.bootcamp.hk/courses/101/linux-basic/lessons

https://www.bootcamp.hk/lessons/myFutureLessons

URL

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thank you
{{-- Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent
