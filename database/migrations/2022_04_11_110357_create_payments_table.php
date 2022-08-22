<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id')->unsigned();
            $table->bigInteger('client_user_id')->unsigned();
            $table->bigInteger('nurse_user_id')->unsigned();
            $table->date('date')->default(\Carbon\Carbon::now()->format('Y-m-d H:i:s'));
            $table->text('note')->nullable();
            $table->integer('sum')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('agency_percent')->default(0);
            $table->string('status')->default('wait')->comment('wait|payed|refuse|break');
            $table->string('currency')->default('EUR');
            $table->string('gateway')->default('bank')->comment('paypal|stripe|cash|bank');

            $table->timestamps();

//            $table->foreign('booking_id')->references('id')->on('bookings');
//            $table->foreign('client_user_id')->references('id')->on('users');
//            $table->foreign('nurse_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
