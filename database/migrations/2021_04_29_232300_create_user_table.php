<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50)->nullable();
            $table->string('password', 64)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('surname', 50)->nullable();
            $table->integer('role_id');
            $table->integer('agency_id');
            $table->integer('group_id');
            $table->string('photo', 200)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('verification', 64)->nullable();
            $table->timestamp('email_verified_at');
            $table->string('remember_token', 64)->nullable();
            $table->string('api_token', 64)->nullable();
            $table->string('comments', 100)->nullable();
            $table->integer('status_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('user');
    }
}
