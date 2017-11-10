@component('mail::message')

@isset($user->nickname)
    Hello, {{ $user->nickname }}
@else
    Hello, {{ $user->name }}
@endisset

@if ($waitlisted)
The class is full. You are currently put on waiting list. If anyone has cancelled enrollment, you will be promoted. please visit our website regularly.
@else 
You have sucessfully enrolled the following class.
@endif 

Class ID: [**{{ $number }}**]({{ $url }})<br>
Course Title: **{{ $lesson->course->title }}**<br>
Sub-Title: {{ $lesson->course->sub_title }}<br>
<br>
Venue: **{{ $lesson->venue }}**  
Schedule: **{{ $lesson->first_day }}** to **{{ $lesson->last_day }}** ({{ $lesson->schedule }})<br>
<br>
[{{ $url }}]({{ $url }})<br>
<br>
<br>
@component('mail::panel')
You coud access your class enrollment detail here: 

**Future Classes**
[https://www.bootcamp.hk/lessons/myFutureLessons](https://www.bootcamp.hk/lessons/myFutureLessons)  

**Current Classes**
[https://www.bootcamp.hk/lessons/myCurrentLessons](https://www.bootcamp.hk/lessons/myCurrentLessons)
@endcomponent

@component('mail::subcopy')
Please remember to bring your notebook and pre-install necessary software.<br>
<small>({{ $sequence }})</small>
@endcomponent
<br>
PS. See you in the class<br>


Thank you
{{-- Thanks,<br>
{{ config('app.name') }} --}}
@endcomponent
