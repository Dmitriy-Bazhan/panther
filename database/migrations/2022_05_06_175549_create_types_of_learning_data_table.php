<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypesOfLearningDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_of_learning_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type_of_learning_id')->unsigned();
            $table->string('lang');
            $table->string('data');
            $table->timestamps();

            $table->foreign('type_of_learning_id')->references('id')->on('types_of_learnings')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types_of_learning_data');
    }
}
