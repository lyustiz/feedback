<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->decimal('progress_day', 9, 2);
            $table->decimal('progress_month', 9, 2);
            $table->decimal('progress_total', 9, 2);
            $table->decimal('progress_max_day', 9, 2);
            $table->decimal('progress_max_month', 9, 2);
            $table->integer('rank');
            $table->integer('milestone_day');
            $table->integer('milestone_month');
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
        Schema::dropIfExists('user_progress');
    }
}
