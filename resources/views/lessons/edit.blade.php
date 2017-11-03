@extends ('layouts.master')

@section ('title', 'Edit Lesson')

@php
    $edit = $course;       // when showing, pass in $course as $edit (old original data)
@endphp

@section ('content')
    <div class="row">
        <span class="mr-auto"><h2>Course Detail</h2></span>
        <span class="ml-auto mr-5">
        </span>
    </div>
    <hr>
    @include ('courses.form', [
        'type'     => 'show',
        'disabled' => 'disabled',           // form-input is disabled
        'course_num_readonly' => 'disabled',    // course_num is not changeable AFTER creation (already disabled above)
        'action'   => '#', 
        'method'   => '', 
        'button'   => '',
        'cancel'   => route('courses.show',  [$course->number]), 
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}
                            
    @include ('lessons.list')
    
    <hr>
    <?php $edit = $edit_lesson; ?>
    <h3 id="lessonSection">Edit a Lesson</h3>
    @include ('lessons.form', [ 
        'type'     => 'edit',
        'disabled' => '',               // don't disable form-input
        'action'   => route('lessons.update', $edit->id),
        'method'=> method_field('PATCH'), 
        'button'   =>'Submit',
        'previousUrl' => url()->previous(),
        ]) 

    <script>
        document.getElementById('lessonSection').scrollIntoView();
    </script>
@endsection