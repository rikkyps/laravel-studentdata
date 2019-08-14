@extends('template')

@section('main')
    <div id="user">
        <h2>Edit User</h2>

        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id]]) !!}
        {{csrf_field()}}
            @include('user.form', ['submitButtonText' => 'Update User'])
        {!! Form::close() !!}
    </div>
@stop

