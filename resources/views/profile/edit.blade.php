@extends ('layouts.master')

@section ('title', 'Update Profile')

@section ('content')
    <h2>Update User Profile</h2>
    <hr>
    @include ('profile.form', [
        'type'     => 'edit',
        'disabled' => '',           // don't disable form-input
        'action'=> action('ProfileController@update', $user->id), 
        'method'=> "", 
        'button'=> 'Submit',
        ]) 
    {{-- need to use relative link to work, https vs http issue --}}

@endsection


