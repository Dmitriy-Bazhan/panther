<?php

namespace App\Providers;

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
        if(Schema::hasTable('settings')){
            $settings = Setting::firstOrFail();
        }

        config([
            'settings' => $settings
        ]);

        config(['paypal.mode' => 'sandbox']);
        config(['paypal.sandbox.client_id' => 'AdjDITvhlEyo2kn-FGH0lM8bZkdLYEqSpBTc_Bi8qlKUPsdo6svYP32mOqI7-Cn4VfZuYSBeIB701XbM']);
        config(['paypal.sandbox.client_secret' => 'ENOBI_idFbX2mQWP5fwJzkTt8TqfN-tPxdIV0d98TfcvZicrW8MadMqxH91KNylpzvc-snq9jOcLwOG2']);
        config(['paypal.live.client_id' => '']);
        config(['paypal.live.client_secret' => '']);
    }
}
