<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEntity = new Admin();
        $adminEntity->save();
        $entityId = $adminEntity->id;

        $admin = new User();
        $admin->first_name = 'admin';
        $admin->last_name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->phone = '123';
        $admin->zip_code = '61000';
        $admin->password = Hash::make('password');
        $admin->entity_id = $entityId;
        $admin->entity_type = 'admin';
        $admin->save();
        $adminId = $admin->id;

        $userPrefs = new UserPref();
        $userPrefs->user_id = $adminId;
        $userPrefs->pref_lang = 'de';
        $userPrefs->save();
    }
}
