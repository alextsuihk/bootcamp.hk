@extends ('layouts.master')

@section ('title', 'Course Detail')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')
    <h2>Course Detail</h2>
    <hr>
    @include ('courses.form', [
        'type'     => 'show',
        'disabled' => 'disabled',           // form-input is disabled
        'action'   => '', 
        'method'   => '', 
        'button'   => '',
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

@endsection
