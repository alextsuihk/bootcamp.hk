@component('mail::message')

@isset($user->nickname)
    Hello, {{ $user->nickname }}
@else
    Hello, {{ $user->name }}
@endisset

You have sucessfully enrolled the following class

Class ID: [**{{ $number }}**]({{ $url }})  
Course Title: **{{ $lesson->course->title }}**  
Venue: **{{ $lesson->venue }}**  
Schedule: **{{ $lesson->first_day }}** ~ **{{ $lesson->last_day }}** ({{ $lesson->schedule }})
[{{ $url }}]({{ $url }})
<br>
<br>

@component('mail::panel')
You coud access your class enrollment detail here: 

Future Classes
[https://www.bootcamp.hk/lessons/myFutureLessons](https://www.bootcamp.hk/lessons/myFutureLessons)  

Current Classes
[https://www.bootcamp.hk/lessons/myCurrentLessons](https://www.bootcamp.hk/lessons/myCurrentLessons)
@endcomponent

@component('mail::subcopy')
Please remember to bring your notebook and pre-install necessary software.  
@endcomponent
<br>
PS. See you in the class  

Thank you
{{-- Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent
