<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerkembanganTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perkembangan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_konten');
            $table->string('judul')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('penggunaan_dana')->nullable();
            $table->text('deskripsi');
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
        Schema::dropIfExists('perkembangan');
    }
}
