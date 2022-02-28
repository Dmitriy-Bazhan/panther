<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_langs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->string('lang')->default('Deutsche');
            $table->string('level')->default('A1');
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
        Schema::dropIfExists('nurse_langs');
    }
}
