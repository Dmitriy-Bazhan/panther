<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SetDefaultSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set/Update data in settings table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Setting::truncate();

        $settings = new Setting();
        $settings->listing_paginate = 12;
        $settings->site_email = 'info@pflegepanther.com';
        $settings->facebook_link = 'https://www.facebook.com/';
        $settings->twitter_link = 'https://twitter.com/';
        $settings->instagram_link = 'https://www.instagram.com/';
        $settings->save();

        echo 'Success';
        return 0;
    }
}
