<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyProgressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id');
            $table->decimal('day_positive', 9, 2);
            $table->decimal('day_negative', 9, 2);
            $table->decimal('month_positive', 9, 2);
            $table->decimal('month_negative', 9, 2);
            $table->decimal('total_positive', 9, 2);
            $table->decimal('total_negative', 9, 2);
            $table->integer('task_mails');
            $table->integer('task_photos');
            $table->integer('task_videos');
            $table->string('comments', 100)->nullable();
            $table->integer('status_id');
            $table->integer('user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_progress');
    }
}
