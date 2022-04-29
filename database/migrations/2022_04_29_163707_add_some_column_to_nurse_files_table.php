<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomeColumnToNurseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nurse_files', function (Blueprint $table) {
            $table->string('original_name')->nullable()->default(null)->change();
            $table->string('file_path')->nullable()->default(null)->change();
            $table->string('file_type')->nullable()->default(null)->change();
            $table->string('thumbnail_path')->nullable();
            $table->string('title')->nullable();
            $table->string('date')->nullable();
            $table->string('place_of_receipt')->nullable();
            $table->text('other_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nurse_files', function (Blueprint $table) {
            $table->dropColumn('thumbnail_path');
            $table->dropColumn('title');
            $table->dropColumn('date');
            $table->dropColumn('place_of_receipt');
            $table->dropColumn('other_info');
        });
    }
}
