<?php

namespace Database\Seeders;

use App\Models\ProvideSupport;
use App\Models\ProvideSupportAssigned;
use Illuminate\Database\Seeder;

class ProviderSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supports = [
            'society_and_care',
            'escort_and_transportation',
            'food_and_drinks',
            'activity_and_exercise',
            'housekeeping_and_laundry',
            'basic_care',
            'purchases_and_errands',
            'technical_assistance',
        ];

        foreach ($supports as $support) {
            $provide = new ProvideSupport();
            $provide->name = $support;
            $provide->save();
        }

//        for ($i = 1; $i <= 5; $i++) {
//            $provideAssigned = new ProvideSupportAssigned();
//            $provideAssigned->nurse_id = $i;
//            $provideAssigned->support_id = rand(1, 8);
//            $provideAssigned->save();
//
//            $provideAssigned = new ProvideSupportAssigned();
//            $provideAssigned->nurse_id = $i;
//            $provideAssigned->support_id = rand(1, 8);
//            $provideAssigned->save();
//        }
    }
}
