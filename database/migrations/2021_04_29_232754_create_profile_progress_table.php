<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->decimal('progress_day', 9, 2);
            $table->decimal('progress_month', 9, 2);
            $table->decimal('progress_total', 9, 2);
            $table->decimal('progress_max_day', 9, 2);
            $table->decimal('progress_max_month', 9, 2);
            $table->integer('crowns');
            $table->integer('hearts');
            $table->integer('milestone_day');
            $table->integer('milestone_month');
            $table->integer('task_mails');
            $table->integer('task_photos');
            $table->integer('task_videos');
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
        Schema::dropIfExists('profile_progress');
    }
}
