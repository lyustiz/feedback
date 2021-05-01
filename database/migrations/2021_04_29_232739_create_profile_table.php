<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amolatina_id');
            $table->string('name', 60);
            $table->date('birthday');
            $table->integer('age');
            $table->string('photo', 200);
            $table->string('gender', 3);
            $table->string('preference', 3);
            $table->string('country', 3);
            $table->string('city', 100);
            $table->integer('minage');
            $table->integer('maxage');
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
        Schema::dropIfExists('profile');
    }
}
