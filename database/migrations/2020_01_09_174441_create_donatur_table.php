<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonaturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donatur', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_konten');
            $table->string('nama');
            $table->boolean('is_anonim');
            $table->boolean('is_diterima');
            $table->integer('jumlah');
            $table->string('bukti');
            //$table->dateTime('created_at');
            $table->foreign('id_konten')->references('id')->on('konten')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('donatur');
    }
}
