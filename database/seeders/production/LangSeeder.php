<?php

namespace Database\Seeders\Production;

use App\Models\Lang;
use Illuminate\Database\Seeder;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(count(Lang::all()) == 0) {
            $lang = new Lang();
            $lang->name = 'english';
            $lang->locale = 'en';
            $lang->save();

            $lang = new Lang();
            $lang->name = 'german';
            $lang->locale = 'de';
            $lang->save();
        }
    }
}
