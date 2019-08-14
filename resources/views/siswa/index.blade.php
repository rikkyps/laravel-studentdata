@extends('template')

@section('main')
<div id="main">
    <h2>Data Siswa</h2>
    @include('_partial.flash_message')
    @include('siswa.form_pencarian')
    @if (!empty($siswa_list))
    <table class="table">
    <thead>
        <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal Lahir</th>
            <th>JK</th>
            <th>Telepon</th>
            <th>Action</th>
        </tr>
    
    <tbody>
    @foreach($siswa_list as $anak)
        <tr>
            <td>{{ $anak->nisn }}</td>
            <td>{{ $anak->nama_siswa }}</td>
            <td>{{$anak->kelas->nama_kelas}}</td>
            <td>{{ $anak->tanggal_lahir->format('d-M-Y') }}</td>
            <td>{{ $anak->jenis_kelamin }}</td>
            <td>{{!empty($anak->telepon->nomor_telepon)?
            $anak->telepon->nomor_telepon : '-'}}</td>
            <td>
                <div class="box-button">
                {{ link_to('siswa/'. $anak->id, 'Detail', ['class' => 'btn btn-success btn-sm']) }}
                </div>

                @if (Auth::check())
                <div class="box-button">
                {{ link_to('siswa/'. $anak->id. '/edit', 'Edit', ['class' => 'btn btn-warning btn-sm']) }}
                </div>
                <div class="box-button">
                {!! Form::open(['method' => 'DELETE', 'action' => ['SiswaController@destroy', $anak->id]]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                {!! Form::close() !!}
                </div>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
    @else
    <p>Data siswa tidak ditemukan</p>
    @endif
    <div class="table-nav">
        <div class="jumlah-data">
            <strong>Jumlah Siswa : {{$jumlah_siswa}}</strong>
        </div>
        <div class="paging">
            {{$siswa_list->links()}}
        </div>
    </div>

@if (Auth::check())
    <div class="tombol-nav">
        <div>
            <a href="siswa/create" class="btn btn-primary">Tambah Siswa</a>
        </div>
    </div>
@endif
    
</div>
@stop

