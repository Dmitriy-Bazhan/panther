<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalInfoAssignedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_info_assigneds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->bigInteger('additional_info_id')->unsigned();
            $table->timestamps();

            $table->foreign('nurse_id')->references('id')->on('nurses')->cascadeOnDelete();
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
        Schema::dropIfExists('additional_info_assigneds');
    }
}
