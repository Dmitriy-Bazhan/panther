<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

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
        // \App\Models\User::factory(10)->create();
    }
}
