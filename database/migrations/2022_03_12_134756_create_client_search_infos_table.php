<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSearchInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_search_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->string('for_whom');
            $table->string('name');
            $table->string('last_name');
            $table->string('age_range');
            $table->json('provider_supports');
            $table->json('disease');
            $table->string('other_disease')->nullable();
            $table->tinyInteger('degree_of_care_available');
            $table->string('language');
            $table->string('language_level');
            $table->string('do_you_need_help_moving');
            $table->string('additional_transportation');
            $table->string('memory');
            $table->string('incontinence');
            $table->string('preference_for_the_nurse');
            $table->string('hearing');
            $table->string('vision');
            $table->string('areas_help');
            $table->string('other_areas')->nullable();
            $table->string('one_time_or_regular')->nullable();
            $table->string('where_should_help_be_provided')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_search_infos');
    }
}
