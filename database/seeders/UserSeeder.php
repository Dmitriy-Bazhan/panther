<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Nurse;
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
        //add admin
        $adminEntity = new Admin();
        $adminEntity->save();
        $entityId = $adminEntity->id;

        $admin = new User();
        $admin->first_name = 'admin';
        $admin->last_name = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = '2022-02-17 12:42:19';
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

        for ($i = 1; $i < 50; $i++) {
            //add client
            $clientEntity = new Client();
            $clientEntity->save();
            $entityId = $clientEntity->id;

            $client = new User();
            $client->first_name = 'Client №' . $i;
            $client->last_name = 'clientovich №' . $i;
            $client->email = 'client' . $i . '@gmail.com';
            $client->email_verified_at = '2022-02-17 12:42:19';
            $client->phone = '123';
            $client->zip_code = '61000';
            $client->password = Hash::make('qwerty');
            $client->entity_id = $entityId;
            $client->entity_type = 'client';
            $client->save();
            $clientId = $client->id;

            $userPrefs = new UserPref();
            $userPrefs->user_id = $clientId;
            $userPrefs->pref_lang = 'de';
            $userPrefs->save();

            //add nurse
            $nurseEntity = new Nurse();
            $nurseEntity->save();
            $entityId = $nurseEntity->id;

            $nurse = new User();
            $nurse->first_name = 'Nurse №' . $i;
            $nurse->last_name = 'Nursovich №' . $i;
            $nurse->email = 'nurse'. $i .'@gmail.com';
            $nurse->email_verified_at = '2022-02-17 12:42:19';
            $nurse->phone = '123';
            $nurse->zip_code = '61000';
            $nurse->password = Hash::make('qwerty');
            $nurse->entity_id = $entityId;
            $nurse->entity_type = 'nurse';
            $nurse->save();
            $nurseId = $nurse->id;

            $userPrefs = new UserPref();
            $userPrefs->user_id = $nurseId;
            $userPrefs->pref_lang = 'de';
            $userPrefs->save();
        }
    }
}
