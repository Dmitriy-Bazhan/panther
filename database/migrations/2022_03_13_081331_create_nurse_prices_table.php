<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->integer('hourly_payment')->default('15');
            $table->string('weekend_surcharge')->default('yes')->comment('yes|no');
            $table->integer('weekend_surcharge_payment')->default(10);
            $table->string('holiday_surcharge')->default('yes')->comment('yes|no');
            $table->integer('holiday_surcharge_payment')->default(10);
            $table->string('fare_surcharge')->default('yes')->comment('yes|no');
            $table->integer('fare_surcharge_payment')->default(10);
            $table->timestamps();

            $table->foreign('nurse_id')->references('id')->on('nurses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nurse_prices');
    }
}
