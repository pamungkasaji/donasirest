<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->unique();
            $table->string('password');
            //$table->string('usertype')->default('user');

            //$table->string('api_token')->nullable();

            $table->string('namalengkap');
            $table->string('alamat');
            $table->string('nomorktp');
            $table->string('nohp');
            $table->string('fotoktp');
            $table->boolean('is_verif')->default(0);
            //$table->dateTime('created_at');

            $table->timestamp('created_at')->useCurrent();
            //$table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
