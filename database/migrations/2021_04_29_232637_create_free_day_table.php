<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_day', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->integer('user_id');
            $table->string('comments', 100)->nullable();
            $table->integer('status_id');
            $table->integer('user_id_ed');
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
        Schema::dropIfExists('free_day');
    }
}
