<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_user_id')->unsigned();
            $table->bigInteger('nurse_user_id')->unsigned();
            $table->text('message')->nullable();
            $table->string('user_name')->default(' ');
            $table->string('client_sent')->nullable()->default(null)->comment('yes -> if client send');
            $table->string('nurse_sent')->nullable()->default(null)->comment('yes -> if nurse send');
            $table->string('status')->nullable()->default('unread')->comment('read|unread');
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
        Schema::dropIfExists('private_chats');
    }
}
