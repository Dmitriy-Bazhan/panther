<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_user_id')->unsigned();
            $table->bigInteger('nurse_user_id')->unsigned();
            $table->string('type')->comment('nurse|client');
            $table->string('status')->nullable()->default('unread')->comment('read|unread');
            $table->text('complaint')->nullable();
            $table->timestamps();

            $table->foreign('client_user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('nurse_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints');
    }
}
