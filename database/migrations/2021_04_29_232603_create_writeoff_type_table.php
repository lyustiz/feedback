<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWriteoffTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writeoff_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('traslate', 60);
            $table->decimal('ammount', 9, 2);
            $table->string('icon', 50)->nullable();
            $table->string('color', 50)->nullable();
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
        Schema::dropIfExists('writeoff_type');
    }
}
