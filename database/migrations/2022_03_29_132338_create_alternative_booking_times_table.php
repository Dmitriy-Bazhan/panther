<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativeBookingTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_booking_times', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('alternative_booking_id')->unsigned();
            $table->string('alternative_time_interval');
            $table->integer('alternative_time');
            $table->timestamps();

            $table->foreign('alternative_booking_id')->references('id')->on('alternative_bookings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_booking_times');
    }
}
