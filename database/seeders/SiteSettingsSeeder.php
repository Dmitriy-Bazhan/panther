<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Setting::count() == 0){
            $settings = new Setting();
            $settings->listing_paginate = 12;
            $settings->site_email = 'info@pflegepanther.com';
            $settings->facebook_link = 'https://www.facebook.com/';
            $settings->twitter_link = 'https://twitter.com/';
            $settings->instagram_link = 'https://www.instagram.com/';
            $settings->save();
        }
    }
}
