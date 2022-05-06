<?php

namespace App\Providers;

use App\Models\Setting;
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
        if (auth()->check()) {
            app()->setLocale(auth()->user()->prefs->pref_lang);
        } else if (isset(request()->post('data')['locale'])) {
            app()->setLocale(request()->post('data')['locale']);
        }

        $settings = Setting::first();

        config([
            'settings' => $settings
        ]);
    }
}
