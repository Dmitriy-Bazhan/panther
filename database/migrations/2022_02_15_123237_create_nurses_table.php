<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurses', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable()->default(null);
            $table->tinyInteger('age')->unsigned()->nullable()->default(null);
            $table->tinyInteger('experience')->unsigned()->default(0);
            $table->tinyInteger('available_care_range')->unsigned()->default(1)->comment('1|2|3|4|5');
            $table->text('description')->nullable()->default(null);
            $table->string('gender')->default('male')->comment('male|female');
            $table->string('pref_client_gender')->default('no_matter')->comment('no_matter|male|female');
            $table->string('multiple_bookings')->default('no')->comment('yes|no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nurses');
    }
}
