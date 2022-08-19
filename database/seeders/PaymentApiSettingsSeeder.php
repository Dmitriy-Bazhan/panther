<?php

namespace Database\Seeders;

use App\Models\PaymentApiSetting;
use Illuminate\Database\Seeder;

class PaymentApiSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (PaymentApiSetting::count() == 0) {
            PaymentApiSetting::create([
                //stripe
                'stripe_key' => 'pk_test_51Kxad8JA09heq2ajolFvGObbLCUHVlcgAKGal5GAcXgjPUjWmANa5wVdaUTncfSQL6Y5IK9adEXoj2yLD2Ac2jDf007yFuP36k',
                'stripe_secret' => 'AjrRH.KE40NaQ1W.aTeZXmVIcY6-AsK3kbt6vP7w9BaDgQJcIb4v3lzP',
                'stripe_currency' => 'eur',

                //paypal
                'paypal_sandbox_client_id' => 'AdjDITvhlEyo2kn-FGH0lM8bZkdLYEqSpBTc_Bi8qlKUPsdo6svYP32mOqI7-Cn4VfZuYSBeIB701XbM',
                'paypal_sandbox_client_secret' => 'ENOBI_idFbX2mQWP5fwJzkTt8TqfN-tPxdIV0d98TfcvZicrW8MadMqxH91KNylpzvc-snq9jOcLwOG2',
                'paypal_sandbox_app_id' => 'APP-80W284485P519543T',
            ]);
        }
    }
}
