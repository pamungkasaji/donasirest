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
            $table->string('usertype')->default('user'); //ada admin

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

            //$table->date('ttl')->nullable();

            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->boolean('confirmed')->nullable();

            //$table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            
            
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
