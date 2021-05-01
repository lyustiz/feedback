<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('type', 60);
            $table->string('group', 20)->nullable();;
            $table->string('value', 200);
            $table->string('start_at', 100)->nullable();;
            $table->string('end_at', 100)->nullable();;
            $table->string('comments', 100)->nullable();
            $table->boolean('active');
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
        Schema::dropIfExists('config');
    }
}
