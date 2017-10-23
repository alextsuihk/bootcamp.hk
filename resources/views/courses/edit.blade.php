@extends ('layouts.master')

@section ('title', 'Modify Course')

@section ('content')
    <h2>Modify Course Detail</h2>
    <hr>
    @include ('courses.form', [
        'action'=> "/courses/$edit->id", 
        'method'=> method_field('PATCH'), 
        'button'=> 'Submit',
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

@endsection