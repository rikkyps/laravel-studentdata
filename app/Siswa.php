<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nisn', 'nama_siswa', 'tanggal_lahir', 'jenis_kelamin', 'id_kelas', 'foto',
    ];

    protected $dates = ['tanggal_lahir'];


    //Accessor dan Mutator
    public function getNamaSiswaAttribute($nama_siswa)
     {
         return ucwords($nama_siswa);
    }

    public function setNamaSiswaAttribute($nama_siswa)
    {
        return $this->attributes['nama_siswa'] = ucwords($nama_siswa);
    }


    // Hubungan Elloquent One to One
    public function telepon()
    {
        return $this->hasOne('App\Telepon', 'id_siswa');
    }

    public function kelas()
    {
        return $this->belongsTo('App\Kelas', 'id_kelas');
    }

    public function hobi()
    {
        return $this->belongsToMany('App\Hobi', 'hobi_siswa', 'id_siswa', 'id_hobi')->withTimeStamps();
    }

    public function getHobiSiswaAttribute()
    {
        return $this->hobi->pluck('id')->toArray();
    }

    public function scopeKelas($query, $id_kelas)
    {
        return $query->where('id_kelas', $id_kelas);
    }

    public function scopeJenisKelamin($query, $jenis_kelamin)
    {
        return $query->where('jenis_kelamin', $jenis_kelamin);
    }
}


