@extends('template')

@section('main')
    <div id="siswa">
        <h2>Edit Siswa</h2>

        {!! Form::model($siswa, ['method' => 'PATCH', 'action' => ['SiswaController@update', $siswa->id], 'files' => true ]) !!}
        {{csrf_field()}}
        @include('siswa.form', ['submitButtonText' => 'Update Siswa'])
        {!! Form::close() !!}
        </div>
@stop