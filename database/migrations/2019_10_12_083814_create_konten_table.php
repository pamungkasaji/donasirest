<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konten', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_user');
            
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('gambar');
            //$table->string('tanggal');
            $table->integer('target');
            $table->integer('terkumpul')->default(0);
            $table->integer('lama_donasi');
            $table->string('nomorrekening');
            //$table->date('created_at');

            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konten');
    }
}
