<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpanjangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpanjangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_konten');
            $table->boolean('is_request');
            $table->integer('jumlah_hari');
            $table->string('alasan');

            $table->foreign('id_konten')->references('id')->on('konten')->onDelete('cascade');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpanjangans');
    }
}
