<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('creator_id')->unsigned();
            $table->bigInteger('target_user_id')->unsigned();
            $table->string('type')->comment('nurse|client');
            $table->text('description');
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users');
            $table->foreign('target_user_id')->references('id')->on('users')->cascadeOnDelete() ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
