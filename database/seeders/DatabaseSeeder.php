<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Database\Seeders\Local\AdditionalInfoSeeder;
use \Database\Seeders\Local\UserSeeder;
use \Database\Seeders\Local\AddTestUsersSeeder;
use \Database\Seeders\Local\ProviderSupportSeeder;
use \Database\Seeders\Local\AddTestProviderSupports;
use \Database\Seeders\Local\HearAboutUsSeeder;
use \Database\Seeders\Local\AddTwoTestRealAccauntsSeader;
use \Database\Seeders\Local\DefaultTranslateSeeder;
use \Database\Seeders\Local\LangSeeder;
use \Database\Seeders\Local\DefaultFeedbackSeeder;
use \Database\Seeders\Local\TimeIntervalSeeder;

use \Database\Seeders\Production\AdditionalInfoSeeder as ProdAdditionalInfoSeeder;
use \Database\Seeders\Production\DefaultTranslateSeeder as ProdDefaultTranslateSeeder;
use \Database\Seeders\Production\HearAboutUsSeeder as ProdHearAboutUsSeeder;
use \Database\Seeders\Production\LangSeeder as ProdLangSeeder;
use \Database\Seeders\Production\ProviderSupportSeeder as ProdProviderSupportSeeder;
use \Database\Seeders\Production\TimeIntervalSeeder as ProdTimeIntervalSeeder;

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
                ProdAdditionalInfoSeeder::class,
                ProdDefaultTranslateSeeder::class,
                ProdHearAboutUsSeeder::class,
                ProdLangSeeder::class,
                ProdProviderSupportSeeder::class,
                ProdTimeIntervalSeeder::class,
            ]);
        }


        // \App\Models\User::factory(10)->create();
    }
}
