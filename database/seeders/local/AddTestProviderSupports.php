<?php

namespace Database\Seeders\Local;

use App\Models\ProvideSupportAssigned;
use Illuminate\Database\Seeder;

class AddTestProviderSupports extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $provideAssigned = new ProvideSupportAssigned();
            $provideAssigned->nurse_id = $i;
            $provideAssigned->support_id = rand(1, 8);
            $provideAssigned->save();

            $provideAssigned = new ProvideSupportAssigned();
            $provideAssigned->nurse_id = $i;
            $provideAssigned->support_id = rand(1, 8);
            $provideAssigned->save();
        }
    }
}
