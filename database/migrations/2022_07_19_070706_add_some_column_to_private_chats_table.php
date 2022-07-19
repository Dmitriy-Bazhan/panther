<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToPrivateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_chats', function (Blueprint $table) {
            $table->string('have_file')->default('no');
            $table->string('original_file')->nullable()->default(null);
            $table->string('thumbnail_file')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_chats', function (Blueprint $table) {
            $table->dropColumn('have_file');
            $table->dropColumn('original_file');
            $table->dropColumn('thumbnail_file');
        });
    }
}
