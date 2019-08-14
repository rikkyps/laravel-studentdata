@extends('template')

@section('main')
    <div id="kelas">
        <h2>Tambah Kelas</h2>

        {!! Form::open(['url' => 'kelas']) !!}
        {{csrf_field()}}
            @include('kelas.form', ['submitButtonText' => 'Tambah Kelas'])
        {!! Form::close() !!}
    </div>
@stop

