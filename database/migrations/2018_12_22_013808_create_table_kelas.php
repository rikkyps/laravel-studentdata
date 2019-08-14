<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableKelas extends Migration
{
    public function up()
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_kelas', 20);
            $table->timestamps();
        });

        //set ForeigKey di kolom id_kelas di tabel siswa
        Schema::table('siswa', function (Blueprint $table){
            $table->foreign('id_kelas')
                  ->references('id')
                  ->on('kelas')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        //Drop FK di kolom id_siswa di kelas table siswa
        Schema::table('siswa', function(Blueprint $table){
            $table->dropForeign('siswa_id_kelas_foreign');
        });
        
        Schema::dropIfExists('kelas');
    }
}
