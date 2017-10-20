@extends ('layouts.master')

@section ('title', 'Modify Workshop')

@section ('content')
    <h2>Modify Workshop Detail</h2>
    {{-- @include ('workshops.form', ['action'=>action('WorkshopController@update', ['id' => $edit->id]), 'button'=>'Submit'])
 --}}    
{{--      @include ('workshops.form', ['action'=>'\workshops\106', 
     'method'=>method_field('PATCH'), 'button'=>'Submit']) --}}

    @include ('workshops.form', ['action'=>route('workshops.update', ['id' => $edit->id], false), 
     'method'=>method_field('PATCH'), 'button'=>'Submit'])      

    {{-- need to use relative link to work, https vs http issue --}}

    @include ('partials.footer')
@endsection
