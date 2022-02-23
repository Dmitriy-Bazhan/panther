<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalInfoDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_info_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('additional_info_id')->unsigned();
            $table->string('lang');
            $table->string('data')->nullable()->default('null');
            $table->timestamps();

            $table->foreign('additional_info_id')->references('id')->on('additional_infos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_info_data');
    }
}
