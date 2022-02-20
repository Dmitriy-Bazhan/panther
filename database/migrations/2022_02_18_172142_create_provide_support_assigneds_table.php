<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvideSupportAssignedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provide_support_assigneds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nurse_id')->unsigned();
            $table->bigInteger('support_id')->unsigned();
            $table->timestamps();

            $table->foreign('nurse_id')->references('id')->on('nurses')->cascadeOnDelete();
            $table->foreign('support_id')->references('id')->on('provide_supports')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provide_support_assigneds');
    }
}
