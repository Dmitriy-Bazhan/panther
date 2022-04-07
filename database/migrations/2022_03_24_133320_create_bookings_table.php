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
            $table->integer('total')->nullable();
            $table->string('is_approved')->default('no')->comment('yes|no');
            $table->string('is_verification')->default('no')->comment('yes|no');
            $table->string('have_alternative')->default('no')->comment('yes|no');
            $table->string('agree_for_alternative')->default('no')->comment('yes|no');
            $table->string('nurse_is_refuse_booking')->default('no')->comment('yes|no');
            $table->string('reason_of_refuse_booking')->nullable();
            $table->string('one_time_or_regular')->default('one')->comment('one|regular');
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();
            $table->integer('weeks')->nullable();
            $table->json('days')->nullable();
            $table->string('additional_email')->nullable();
            $table->text('comment')->nullable();
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
