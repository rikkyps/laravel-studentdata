@extends('template')

@section('main')
    <div id="hobi">
        <h2>Tambah Hobi</h2>
        {!! Form::open(['url' => 'hobi']) !!}
        {{csrf_field()}}
        @include('hobi.form', ['submitButtonText' => 'Tambah Hobi'])
        {!! Form::close() !!}
</div>
@stop
