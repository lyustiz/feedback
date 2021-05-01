<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 20);
            $table->string('grupo', 20);
            $table->integer('profile_id');
            $table->integer('bonus_type_id');
            $table->integer('start_at');
            $table->integer('end_at');
            $table->integer('payment_class_id');
            $table->decimal('ammount', 9, 2);
            $table->integer('times');
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
        Schema::dropIfExists('payment');
    }
}
