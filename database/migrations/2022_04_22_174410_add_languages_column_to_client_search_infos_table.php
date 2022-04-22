<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguagesColumnToClientSearchInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_search_infos', function (Blueprint $table) {
            $table->dropColumn('language');
            $table->dropColumn('language_level');
            $table->json('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_search_infos', function (Blueprint $table) {
            $table->string('language');
            $table->string('language_level');
            $table->dropColumn('languages');
        });
    }
}
