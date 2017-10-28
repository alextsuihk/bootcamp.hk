@extends ('layouts.master')

@section ('title', 'Modify Course')

@section ('content')
    <h2>Modify Course Detail</h2>
    <hr>
    @include ('courses.form', [
        'type'     => 'edit',
        'disabled' => '',           // don't disable form-input
        'course_num_readonly' => 'disabled',    // course_num is not changeable AFTER creation
        'action'=> "/courses/$edit->id", 
        'method'=> method_field('PATCH'), 
        'button'=> 'Submit',
        'cancel'   => route('courses.show',  [$edit->number]), 
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

    {{-- AT-Pending: pull in TinyMCE 
        https://www.youtube.com/watch?v=VgxDWv-VUAA&index=51&list=PLwAKR305CRO-Q90J---jXVzbOd4CDRbVx --}}

@endsection