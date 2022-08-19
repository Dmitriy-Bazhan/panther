<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserDataColumnToPaymentApiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_api_settings', function (Blueprint $table) {
            $table->string('paypal_sandbox_username')->default('sb-3pxkh20269640_api1.business.example.com');
            $table->string('paypal_sandbox_password')->default('V34W69B9EBM2PFFK');

            $table->string('paypal_live_username')->nullable();
            $table->string('paypal_live_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_api_settings', function (Blueprint $table) {
            $table->dropColumn('paypal_sandbox_username');
            $table->dropColumn('paypal_sandbox_password');
            $table->dropColumn('paypal_live_username');
            $table->dropColumn('paypal_live_password');
        });
    }
}
