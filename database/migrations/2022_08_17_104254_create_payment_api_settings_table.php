<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentApiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_api_settings', function (Blueprint $table) {
            $table->id();
            //stripe
            $table->string('stripe_key')->default('');
            $table->string('stripe_secret')->default('');
            $table->string('stripe_currency')->default('');

            //paypal
            $table->string('paypal_mode')->default('sandbox');
            $table->string('paypal_sandbox_client_id')->default('');
            $table->string('paypal_sandbox_client_secret')->default('');
            $table->string('paypal_sandbox_app_id')->default('');
            $table->string('paypal_live_client_id')->nullable();
            $table->string('paypal_live_client_secret')->nullable();
            $table->string('paypal_live_app_id')->nullable();

            $table->string('paypal_payment_action')->default('Sale');
            $table->string('paypal_currency')->default('EUR');
            $table->string('paypal_notify_url')->nullable();
            $table->string('paypal_locale')->default('en_US');
            $table->boolean('paypal_validate_ssl')->default(true);

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
        Schema::dropIfExists('payment_api_settings');
    }
}
