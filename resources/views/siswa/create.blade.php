@extends('template')

@section('main')
    <div id="siswa">
        <h2>Tambah Siswa</h2>
        <!-- Code Validasi --->
        <!--@include('errors.form_error_list')-->
        {!! Form::open(['url' =>'siswa', 'files' => true]) !!}
        {{csrf_field()}}
        @include('siswa.form', ['submitButtonText' => 'Update Siswa'])
        {!! Form::close() !!}
        </div>
@stop
            
        
            
