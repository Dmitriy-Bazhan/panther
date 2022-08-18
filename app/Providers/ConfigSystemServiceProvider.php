<?php

namespace App\Providers;

use App\Models\PaymentApiSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ConfigSystemServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $settings = [];
        if (Schema::hasTable('settings')) {
            $settings = Setting::first();
            if ($settings) {
                config(['settings' => $settings]);
            }
        }


        $payment_api_settings = [];
        if (Schema::hasTable('payment_api_settings')) {
            $payment_api_settings = PaymentApiSetting::first();

            if ($payment_api_settings) {
                //paypal
                config(['paypal.mode' => $payment_api_settings->paypal_mode]);
                config(['paypal.sandbox.client_id' => $payment_api_settings->paypal_sandbox_client_id]);
                config(['paypal.sandbox.client_secret' => $payment_api_settings->paypal_sandbox_client_secret]);
                config(['paypal.live.client_id' => $payment_api_settings->paypal_live_client_id]);
                config(['paypal.live.client_secret' => $payment_api_settings->paypal_live_client_secret]);
                config(['paypal.live.app_id' => $payment_api_settings->paypal_live_app_id]);

                config(['paypal.payment_action' => $payment_api_settings->paypal_payment_action]);
                config(['paypal.currency' => $payment_api_settings->paypal_currency]);
                config(['paypal.notify_url' => $payment_api_settings->paypal_notify_url]);
                config(['paypal.locale' => $payment_api_settings->paypal_locale]);
                config(['paypal.validate_ssl' => $payment_api_settings->paypal_validate_ssl]);


                //stripe
                config(['cashier.key' => $payment_api_settings->stripe_key]);
                config(['cashier.secret' => $payment_api_settings->stripe_secret]);
                config(['cashier.currency' => $payment_api_settings->stripe_currency]);
            }

        }
    }
}
