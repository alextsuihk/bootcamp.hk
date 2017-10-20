@extends ('layouts.master')

@section ('title', 'Adding Workshop')

@section ('content')
    <h2>Add a Workshop</h2>
    @include ('workshops.form', ['action'=>action('WorkshopController@store'), 'method'='', 'button'=>'Submit'])
    @include ('partials.footer')
@endsection