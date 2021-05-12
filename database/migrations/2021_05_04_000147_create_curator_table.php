<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuratorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curator', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->integer('amolatina_id');
            $table->decimal('value', 9, 2);
            $table->decimal('percent', 3, 2);
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
        Schema::dropIfExists('curator');
    }
}
