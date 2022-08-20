<?php

namespace Database\Seeders;

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
        if (ProvideSupportAssigned::count() == 0) {
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
}
