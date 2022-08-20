<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangesColumntToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('client_fullname')->nullable();
            $table->string('client_phone')->nullable();
        });

        Schema::table('booking_times', function (Blueprint $table) {
            $table->string('time')->change();
        });

        Schema::table('alternative_booking_times', function (Blueprint $table) {
            $table->string('alternative_time')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('client_fullname');
            $table->dropColumn('client_phone');
        });

        Schema::table('booking_times', function (Blueprint $table) {
            $table->integer('time')->change();
        });

        Schema::table('alternative_booking_times', function (Blueprint $table) {
            $table->integer('alternative_time')->change();
        });
    }
}
