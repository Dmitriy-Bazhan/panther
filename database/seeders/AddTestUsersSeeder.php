<?php

namespace Database\Seeders;

use App\Models\AdditionalInfoAssigned;
use App\Models\Client;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\NurseLang;
use App\Models\NursePrice;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddTestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
            $nurseEntity->age = rand(20, 55);
            $nurseEntity->description = 'DESCRIPTION';
            $nurseEntity->available_care_range = rand(0, 5);
            $nurseEntity->save();
            $entityId = $nurseEntity->id;

            $nurse = new User();
            $nurse->first_name = 'Nurse №' . $i;
            $nurse->last_name = 'Nursovich №' . $i;
            $nurse->email = 'nurse' . $i . '@gmail.com';
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

            $nursePrice = new NursePrice();
            $nursePrice->nurse_id = $entityId;
            $nursePrice->save();
        }

        Nurse::where('id', 1)->update([
            'original_photo' => 'user_3/photo/original_photo_user_3.jpg',
            'thumbnail_photo' => 'user_3/photo/thumbnail_photo_user_3.jpg',
            'info_is_full' => 'yes',
            'is_approved' => 'yes',
            'change_info' => 'no',
            'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
        ]);

        Nurse::where('id', 2)->update([
            'original_photo' => 'user_5/photo/original_photo_user_5.jpg',
            'thumbnail_photo' => 'user_5/photo/thumbnail_photo_user_5.jpg',
            'info_is_full' => 'yes',
            'is_approved' => 'yes',
            'change_info' => 'no',
            'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
        ]);

        Nurse::where('id', 3)->update([
            'original_photo' => 'user_7/photo/original_photo_user_7.jpg',
            'thumbnail_photo' => 'user_7/photo/thumbnail_photo_user_7.jpg',
            'info_is_full' => 'yes',
            'is_approved' => 'yes',
            'change_info' => 'no',
            'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
        ]);

        Nurse::where('id', 4)->update([
            'original_photo' => 'user_9/photo/original_photo_user_9.jpg',
            'thumbnail_photo' => 'user_9/photo/thumbnail_photo_user_9.jpg',
            'info_is_full' => 'yes',
            'is_approved' => 'yes',
            'change_info' => 'no',
            'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
        ]);

        Nurse::where('id', 5)->update([
            'original_photo' => 'user_11/photo/original_photo_user_11.jpg',
            'thumbnail_photo' => 'user_11/photo/thumbnail_photo_user_11.jpg',
            'info_is_full' => 'yes',
            'is_approved' => 'yes',
            'change_info' => 'no',
            'work_time_pref' => '{"weekdays_7_11": "1", "weekends_7_11": "0", "weekdays_11_14": "1", "weekdays_14_17": "0", "weekdays_17_21": "0", "weekends_11_14": "0", "weekends_14_17": "0", "weekends_17_21": "0"}',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $infoAssigned = new AdditionalInfoAssigned();
            $infoAssigned->nurse_id = $i;
            $infoAssigned->additional_info_id = rand(1, 13);
            $infoAssigned->save();
        }

        $file = new NurseFile();
        $file->nurse_id = 1;
        $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
        $file->file_path = 'user_3/criminal_record/criminal_record_photo_user_3_number_0.jpg';
        $file->file_type = 'criminal_record';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 1;
        $file->original_name = 'IMG-57fae761aac790e3af4e7dcf239ab56f-V.jpg';
        $file->file_path = 'user_3/documentation_of_training/documentation_of_training_photo_user_3_number_0.jpg';
        $file->file_type = 'documentation_of_training';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 2;
        $file->original_name = 'IMG_20180720_201158.jpg';
        $file->file_path = 'user_5/criminal_record/criminal_record_photo_user_5_number_0.jpg';
        $file->file_type = 'criminal_record';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 2;
        $file->original_name = 'IMG_20180720_201158.jpg';
        $file->file_path = 'user_5/documentation_of_training/documentation_of_training_photo_user_5_number_0.jpg';
        $file->file_type = 'documentation_of_training';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 3;
        $file->original_name = 'IMG_20180709_214713.jpg';
        $file->file_path = 'user_7/criminal_record/criminal_record_photo_user_7_number_0.jpg';
        $file->file_type = 'criminal_record';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 3;
        $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
        $file->file_path = 'user_7/documentation_of_training/documentation_of_training_photo_user_7_number_0.jpg';
        $file->file_type = 'documentation_of_training';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 4;
        $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
        $file->file_path = 'user_9/criminal_record/criminal_record_photo_user_9_number_0.jpg';
        $file->file_type = 'criminal_record';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 4;
        $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
        $file->file_path = 'user_9/documentation_of_training/documentation_of_training_photo_user_9_number_0.jpg';
        $file->file_type = 'documentation_of_training';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 5;
        $file->original_name = 'IMG-50b97907cbdec4ff88331adef5680fa9-V.jpg';
        $file->file_path = 'user_11/criminal_record/criminal_record_photo_user_11_number_0.jpg';
        $file->file_type = 'criminal_record';
        $file->save();

        $file = new NurseFile();
        $file->nurse_id = 5;
        $file->original_name = 'IMG-57fae761aac790e3af4e7dcf239ab56f-V.jpg';
        $file->file_path = 'user_11/documentation_of_training/documentation_of_training_photo_user_11_number_0.jpg';
        $file->file_type = 'documentation_of_training';
        $file->save();

        $lang = new NurseLang();
        $lang->nurse_id = 1;
        $lang->lang = 'Deutsche';
        $lang->level = 'B1';
        $lang->save();

        $lang = new NurseLang();
        $lang->nurse_id = 2;
        $lang->lang = 'English';
        $lang->level = 'B1';
        $lang->save();

        $lang = new NurseLang();
        $lang->nurse_id = 3;
        $lang->lang = 'English';
        $lang->level = 'A1';
        $lang->save();

        $lang = new NurseLang();
        $lang->nurse_id = 4;
        $lang->lang = 'Deutsche';
        $lang->level = 'B1';
        $lang->save();

        $lang = new NurseLang();
        $lang->nurse_id = 5;
        $lang->lang = 'Deutsche';
        $lang->level = 'C1';
        $lang->save();
    }
}
