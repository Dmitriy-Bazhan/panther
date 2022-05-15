<?php

namespace Database\Seeders;

use App\Models\ProvideSupport;
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
        if (ProvideSupport::all()->count() == 0) {
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
        }


    }
}
