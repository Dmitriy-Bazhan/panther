<?php

namespace App\Http\Repositories;

use App\Models\AdditionalInfoAssigned;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\NurseLang;
use App\Models\NursePrice;
use App\Models\ProvideSupportAssigned;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;

class NurseRepository
{
    protected $nurse;

    public function __construct(User $nurse)
    {
        $this->nurse = $nurse;
    }

    public function search($id = null)
    {

        $nurse = $this->nurse->newQuery();
        //only nurses
        $nurse->where('entity_type', 'nurse');

        if (!is_null($id)) {
            $nurse->where('id', $id);
        }

        //get nurses to admin/nurses list
        if (request()->filled('only_full_info') && request('only_full_info') == 'yes') {
            $nurse->whereHas('nurse', function ($query) {
                return $query->where('info_is_full', 'yes')->orWhere('change_info', 'yes')->orWhere('is_approved', 'yes');
            });
        }

        //filters is approved
        if (request()->filled('is_approved') && request('is_approved') == 'yes') {
            $nurse->whereHas('nurse', function ($query) {
                return $query->where('is_approved', '=', 'yes');
            });
        }

        //filter provider_supports
        if (request()->filled('provider_supports') && is_array(request('provider_supports'))) {
            $nurse->whereHas('nurse', function ($query) {
                return $query->whereHas('provideSupports', function ($query) {
                    return $query->whereIn('support_id', request('provider_supports'));
                });
            });
        }

        //filter degree_of_care_available
        if (request()->filled('degree_of_care_available') && is_numeric(request('degree_of_care_available'))) {
            $nurse->whereHas('nurse', function ($query) {
                return $query->where('available_care_range', '=', request('degree_of_care_available'));
            });
        }

        //filter language
        if (request()->filled('language') && request('language') != 'no_matter') {
            $nurse->whereHas('nurse', function ($query) {
                return $query->whereHas('languages', function ($query) {
                    return $query->where('lang', request('language'));
                });
            });
        }

        //filter language_level
        if (request()->filled('language_level') && request('language_level') != 'no_matter') {
            $nurse->whereHas('nurse', function ($query) {
                return $query->whereHas('languages', function ($query) {
                    return $query->where('level', request('language_level'));
                });
            });
        }

        //filter preference_for_the_nurse
        if (request()->filled('preference_for_the_nurse')) {
            $nurse->whereHas('nurse', function ($query) {
                return $query->where('pref_client_gender', '=', request('preference_for_the_nurse'));
            });
        }

        //order (only for some nurses)
        if (is_null($id)) {
            if (request()->filled('order_by')) {

            } else {
//                default order(info_is_full is hidden var, needed only order)
                $nurse->select('users.*', 'nurses.info_is_full', 'nurses.change_info')
                    ->leftJoin('nurses', 'users.entity_id', '=', 'nurses.id');
                $nurse->orderByDesc('info_is_full')->orderByDesc('change_info');
            }
        }

        $nurse->without('prefs');

        return $nurse->paginate(10);
    }

    public function update($nurse)
    {
        $data = json_decode(request()->all('user')['user'], true);

        User::where('id', $nurse->id)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'zip_code' => $data['zip_code'],
        ]);

        $change_info = 'no';
        $info_is_full = 'yes';
        if ($nurse->entity->info_is_full == 'yes') {
            $change_info = 'yes';
            $info_is_full = 'no';
        }

        Nurse::where('id', $nurse->entity_id)->update([
            'info_is_full' => $info_is_full,
            'change_info' => $change_info,
        ]);

        Nurse::where('id', $data['entity_id'])->update([
            'age' => $data['entity']['age'],
            'available_care_range' => $data['entity']['available_care_range'],
            'description' => $data['entity']['description'],
            'experience' => $data['entity']['experience'],
            'gender' => $data['entity']['gender'],
            'multiple_bookings' => $data['entity']['multiple_bookings'],
            'pref_client_gender' => $data['entity']['pref_client_gender'],
            'work_time_pref' => json_encode($data['entity']['work_time_pref']),
        ]);

        //update lang (remake to foreach, then in future will use some languages)
        NurseLang::updateOrCreate(
            ['nurse_id' => $data['entity_id']],
            [
                'lang' => $data['entity']['languages'][0]['lang'],
                'level' => $data['entity']['languages'][0]['level'],
            ]);

        ProvideSupportAssigned::where('nurse_id', $data['entity_id'])->delete();
        if (count($data['entity']['provide_supports']) > 0) {
            foreach ($data['entity']['provide_supports'] as $item) {
                ProvideSupportAssigned::create([
                    'nurse_id' => $data['entity_id'],
                    'support_id' => $item['id'],
                ]);
            }
        }

        //additional info
        AdditionalInfoAssigned::where('nurse_id', $data['entity_id'])->delete();
        if (count($data['entity']['additional_info']) > 0) {
            foreach ($data['entity']['additional_info'] as $item) {
                AdditionalInfoAssigned::create([
                    'nurse_id' => $data['entity_id'],
                    'additional_info_id' => $item['id'],
                ]);
            }
        }
        return true;
    }

    public function uploadDocuments(Request $request, $nurse)
    {

        $arr = ['criminal_record', 'documentation_of_training', 'CPR_course', 'references'];

        foreach ($request->allFiles() as $key => $documents) {
            if (!in_array($key, $arr)) {
                continue;
            }

            if (count($documents) == 0) {
                continue;
            }

            $files = $request->file($key);
            $directory_name = 'user_' . $nurse->id . '/' . $key;
            $existedPhotos = Storage::disk('public')->files($directory_name);
            if (count($existedPhotos) > 0) {
                Storage::disk('public')->deleteDirectory($directory_name);
                NurseFile::where('nurse_id', $nurse->entity_id)->where('file_type', $key)->delete();
            }

            foreach ($files as $document) {
                $original_name = $document->getClientOriginalName();
                $file_name = $key . '_photo_user_' . $nurse->id . '_' . $document->getClientOriginalName();
                $file_path = Storage::disk('public')->putFileAs($directory_name, $document, $file_name);

                NurseFile::create([
                    'nurse_id' => $nurse->entity_id,
                    'original_name' => $original_name,
                    'file_path' => $file_path,
                    'file_type' => $key
                ]);
            }
        }

        return true;
    }

    public function uploadPhoto(Request $request, $id)
    {

        if ($request->file('file')) {
            $file_name = 'original_photo_user_' . $id . '_' . $request->file('file')->getClientOriginalName();
            $thumbnail_name = 'thumbnail_photo_user_' . $id . '_' . $request->file('file')->getClientOriginalName();
            $directory_name = 'user_' . $id . '/photo';
            $existedPhotos = Storage::disk('public')->files($directory_name);
            if (count($existedPhotos) > 0) {
                Storage::disk('public')->deleteDirectory($directory_name);
                $original_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
                $thumbnail_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $thumbnail_name);
            } else {
                $original_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
                $thumbnail_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $thumbnail_name);
            }

            //make thumbnail or avatar
            $img = Image::make('storage/' . $thumbnail_path)->resize(40, 40, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save();

            Nurse::where('id', auth()->user()->entity_id)->update([
                'original_photo' => $original_path,
                'thumbnail_photo' => $thumbnail_path,
            ]);

        }
        return true;
    }

    public function updatePrice($price = null)
    {
        if (is_null($price) || !is_array($price)) {
            return false;
        }

        $success = NursePrice::where('id', $price['id'])->update([
            'hourly_payment' => $price['hourly_payment'],
            'weekend_surcharge' => $price['weekend_surcharge'],
            'weekend_surcharge_payment' => $price['weekend_surcharge_payment'],
            'holiday_surcharge' => $price['holiday_surcharge'],
            'holiday_surcharge_payment' => $price['holiday_surcharge_payment'],
            'fare_surcharge' => $price['fare_surcharge'],
            'fare_surcharge_payment' => $price['fare_surcharge_payment'],
        ]);

        if ($success) {
            return true;
        } else {
            return false;
        }

    }
}
