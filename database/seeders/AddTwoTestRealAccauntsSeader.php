<?php

namespace Database\Seeders;

use App\Models\AdditionalInfoAssigned;
use App\Models\Client;
use App\Models\ClientSearchInfo;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\NurseLang;
use App\Models\NursePrice;
use App\Models\ProvideSupportAssigned;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddTwoTestRealAccauntsSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where('email', 'dbazhanwork1@gmail.com')->first()) {
            //add real test mail client
            $clientEntity = new Client();
            $clientEntity->save();
            $entityId = $clientEntity->id;

            $client = new User();
            $client->first_name = 'Test';
            $client->last_name = 'Client';
            $client->email = 'dbazhanwork1@gmail.com';
            $client->email_verified_at = '2022-02-17 12:42:19';
            $client->phone = '123-123-123';
            $client->zip_code = '61000';
            $client->password = Hash::make('qwerty');
            $client->entity_id = $entityId;
            $client->entity_type = 'client';
            $client->save();
            $clientId = $client->id;

            $client_search_info = new ClientSearchInfo();
            $client_search_info->client_id = $entityId;
            $client_search_info->for_whom = 'to_me';
            $client_search_info->name = 'Test';
            $client_search_info->last_name = 'Client';
            $client_search_info->age_range = '20-40';
            $client_search_info->provider_supports = '[1, 2, 3, 4, 5, 6, 7, 8]';
            $client_search_info->disease = '[]';
            $client_search_info->other_disease = null;
            $client_search_info->degree_of_care_available = 0;
            $client_search_info->do_you_need_help_moving = 'unknown';
            $client_search_info->additional_transportation = 'unknown';
            $client_search_info->memory = 'unknown';
            $client_search_info->incontinence = 'unknown';
            $client_search_info->preference_for_the_nurse = 'no_matter';
            $client_search_info->hearing = 'unknown';
            $client_search_info->vision = 'unknown';
            $client_search_info->areas_help = 'hygiene';
            $client_search_info->other_areas = null;
            $client_search_info->where_should_help_be_provided = null;
            $client_search_info->one_or_regular = 'one';
            $client_search_info->one_time_date = '2022-08-20';
            $client_search_info->regular_time_start_date = null;
            $client_search_info->regular_time_finish_date = null;
            $client_search_info->work_time_pref = '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "1", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}';
            $client_search_info->created_at = '2022-08-19 14:54:31';
            $client_search_info->updated_at = '2022-08-19 14:55:58';
            $client_search_info->languages = '[{"id": null, "level": "A1"}]';
            $client_search_info->save();

            $userPrefs = new UserPref();
            $userPrefs->user_id = $clientId;
            $userPrefs->pref_lang = 'en';
            $userPrefs->save();

            //add real test mail nurse
            $nurseEntity = new Nurse();
            $nurseEntity->age = rand(20, 55);
            $nurseEntity->description = 'DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION DESCRIPTION';
            $nurseEntity->available_care_range = rand(0, 5);
            $nurseEntity->save();
            $entityId = $nurseEntity->id;

            $nurse = new User();
            $nurse->first_name = 'Test';
            $nurse->last_name = 'Nurse';
            $nurse->email = 'dbazhanwork2@gmail.com';
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
            $userPrefs->pref_lang = 'en';
            $userPrefs->save();

            $nursePrice = new NursePrice();
            $nursePrice->nurse_id = $entityId;
            $nursePrice->save();

            Nurse::where('id', $entityId)->update([
                'original_photo' => 'user_' . $nurseId . '/photo/original_photo_user_' . $nurseId . '.jpg',
                'thumbnail_photo' => 'user_' . $nurseId . '/photo/thumbnail_photo_user_' . $nurseId . '.jpg',
                'info_is_full' => 'yes',
                'is_approved' => 'yes',
                'change_info' => 'no',
                'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
            ]);

            for ($i = 1; $i <= 3; $i++) {
                $infoAssigned = new AdditionalInfoAssigned();
                $infoAssigned->nurse_id = $entityId;
                $infoAssigned->additional_info_id = rand(1, 13);
                $infoAssigned->save();
            }

            for ($i = 1; $i <= 5; $i++) {
                $provideAssigned = new ProvideSupportAssigned();
                $provideAssigned->nurse_id = $entityId;
                $provideAssigned->support_id = $i;
                $provideAssigned->save();
            }

//            $file = new NurseFile();
//            $file->nurse_id = $entityId;
//            $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
//            $file->file_path = 'user_' . $nurseId . '/criminal_record/criminal_record_photo_user_' . $nurseId . '_number_0.jpg';
//            $file->file_type = 'criminal_record';
//            $file->save();
//
//            $file = new NurseFile();
//            $file->nurse_id = $entityId;
//            $file->original_name = 'IMG-57fae761aac790e3af4e7dcf239ab56f-V.jpg';
//            $file->file_path = 'user_' . $nurseId . '/documentation_of_training/documentation_of_training_photo_user_' . $nurseId . '_number_0.jpg';
//            $file->file_type = 'documentation_of_training';
//            $file->save();

            $lang = new NurseLang();
            $lang->nurse_id = $entityId;
            $lang->lang_id = 1;
            $lang->lang = 'english';
            $lang->level = 'A1';
            $lang->save();
        }
    }
}
