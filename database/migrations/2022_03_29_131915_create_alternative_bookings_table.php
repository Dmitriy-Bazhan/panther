<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlternativeBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned();
            $table->integer('alternative_suggested_price_per_hour')->nullable();
            $table->integer('total')->nullable();
            $table->string('alternative_one_time_or_regular')->default('one')->comment('one|regular');
            $table->date('alternative_start_date')->nullable();
            $table->date('alternative_finish_date')->nullable();
            $table->integer('alternative_weeks')->nullable();
            $table->json('alternative_days')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_bookings');
    }
}
