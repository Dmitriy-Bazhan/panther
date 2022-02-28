<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->string('original_name')->default('null');
            $table->string('file_path')->default('null');
            $table->string('file_type')->default('null');
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
        Schema::dropIfExists('nurse_files');
    }
}
