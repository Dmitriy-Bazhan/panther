<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHearAboutUsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hear_about_us_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('near_about_us_id')->unsigned();
            $table->string('lang')->comment('en|de');
            $table->string('data')->nullable();
            $table->timestamps();

            $table->foreign('near_about_us_id')->references('id')->on('hear_about_us')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hear_about_us_data');
    }
}
