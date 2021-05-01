<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bonus_id');
            $table->string('service', 100)->nullable();
            $table->string('fact', 200)->nullable();
            $table->integer('cllient_id');
            $table->integer('profile_id');
            $table->decimal('points', 9, 2);
            $table->decimal('profit', 9, 2);
            $table->integer('share');
            $table->string('comments', 100)->nullable();
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
        Schema::dropIfExists('bonus');
    }
}
