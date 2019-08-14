@extends('template')

@section('main')
    <div id="user">
        <h2>Tambah User</h2>

        {!! Form::open(['url' => 'user']) !!}
        {{csrf_field()}}
        @include('user.form', ['submitButtonText' => 'Tambah User'])
        {!! Form::close() !!}
    </div>
@stop

