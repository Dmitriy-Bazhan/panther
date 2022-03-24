<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_user_id')->unsigned();
            $table->bigInteger('client_user_id')->unsigned();
            $table->integer('hourly_price')->nullable();
            $table->integer('suggested_price_per_hour')->nullable();
            $table->string('is_approved')->default('no')->comment('yes|no');
            $table->string('one_time_or_regular')->default('one_time')->comment('one_time|regular');
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->integer('weeks')->nullable();
            $table->json('days')->nullable();
            $table->timestamps();

            $table->foreign('nurse_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('client_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
