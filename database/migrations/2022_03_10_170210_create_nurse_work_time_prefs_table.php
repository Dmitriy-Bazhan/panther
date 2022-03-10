<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseWorkTimePrefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_work_time_prefs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->string('work_time');
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
        Schema::dropIfExists('nurse_work_time_prefs');
    }
}
