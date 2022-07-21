<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Database\Seeders\AdditionalInfoSeeder;
use \Database\Seeders\UserSeeder;
use \Database\Seeders\AddTestUsersSeeder;
use \Database\Seeders\ProviderSupportSeeder;
use \Database\Seeders\AddTestProviderSupports;
use \Database\Seeders\HearAboutUsSeeder;
use \Database\Seeders\AddTwoTestRealAccauntsSeader;
use \Database\Seeders\DefaultTranslateSeeder;
use \Database\Seeders\LangSeeder;
use \Database\Seeders\DefaultFeedbackSeeder;
use \Database\Seeders\TimeIntervalSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'local') {
            $this->call([
                AdditionalInfoSeeder::class,
                UserSeeder::class,
                //AddTestUsersSeeder::class,   //only for test, comment after deploy
                ProviderSupportSeeder::class,
                //AddTestProviderSupports::class,  //only for test, comment after deploy
                HearAboutUsSeeder::class,
                //AddTwoTestRealAccauntsSeader::class,
                DefaultTranslateSeeder::class,
                LangSeeder::class,
                DefaultFeedbackSeeder::class,
                TimeIntervalSeeder::class,
            ]);
        }

        if (env('APP_ENV') === 'production') {
            $this->call([
                AdditionalInfoSeeder::class,
                DefaultTranslateSeeder::class,
                HearAboutUsSeeder::class,
                LangSeeder::class,
                ProviderSupportSeeder::class,
                TimeIntervalSeeder::class,
            ]);
        }


        // \App\Models\User::factory(10)->create();
    }
}
