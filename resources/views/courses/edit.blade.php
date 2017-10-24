@extends ('layouts.master')

@section ('title', 'Modify Course')

@section ('content')
    <h2>Modify Course Detail</h2>
    <hr>
    @include ('courses.form', [
        'type'     => 'edit',
        'disabled' => '',           // don't disable form-input
        'action'=> "/courses/$edit->id", 
        'method'=> method_field('PUT'), 
        'button'=> 'Submit',
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

    {{-- AT-Pending: pull in TinyMCE 
        https://www.youtube.com/watch?v=VgxDWv-VUAA&index=51&list=PLwAKR305CRO-Q90J---jXVzbOd4CDRbVx --}}

@endsection