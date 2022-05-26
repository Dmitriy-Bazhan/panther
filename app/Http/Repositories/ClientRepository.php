<?php


namespace App\Http\Repositories;


use App\Models\Client;
use App\Models\ClientSearchInfo;
use App\Models\Nurse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;

class ClientRepository
{
    protected $client;

    public function __construct(User $client)
    {
        $this->client = $client;
    }

    public function search($id = null)
    {

        $client = $this->client->newQuery();

        $client->where('entity_type', 'client');

        if (!is_null($id)) {
            $client->where('id', $id);
        }

        //order (only for some clients)
        if (is_null($id)) {
            if (request()->filled('order_by')) {

            } else {
                //default order
//                $client->orderByDesc('created_at');
            }
        }

        return $client->paginate(config('settings.listing_paginate'));
    }

    public function update($client)
    {
        $data = json_decode(request()->all('user')['user'], true);

        User::where('id', $client->id)->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'zip_code' => $data['zip_code'],
        ]);

        Client::where('id', $data['entity_id'])->update([
            'description' => $data['entity']['description'],
            'gender' => $data['entity']['gender'],
        ]);

        return true;
    }

    public function uploadPhoto($request, $id)
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

            Client::where('id', auth()->user()->entity_id)->update([
                'original_photo' => $original_path,
                'thumbnail_photo' => $thumbnail_path,
            ]);

        }
        return true;
    }

    public function store($clientSearchInfo)
    {

        if (!isset($clientSearchInfo['client_id'])) {
            $clientSearchInfo['client_id'] = auth()->user()->entity->id;
        }

        $success = ClientSearchInfo::updateOrCreate(
            ['client_id' => $clientSearchInfo['client_id']],
            [
                'for_whom' => $clientSearchInfo['for_whom'],
                'name' => $clientSearchInfo['name'],
                'last_name' => $clientSearchInfo['last_name'],
                'age_range' => $clientSearchInfo['age_range'],
                'provider_supports' => json_encode($clientSearchInfo['provider_supports']),
                'disease' => json_encode($clientSearchInfo['disease']),
                'other_disease' => $clientSearchInfo['other_disease'],
                'degree_of_care_available' => $clientSearchInfo['degree_of_care_available'],
                'languages' => json_encode($clientSearchInfo['languages']),
                'do_you_need_help_moving' => $clientSearchInfo['do_you_need_help_moving'],
                'additional_transportation' => $clientSearchInfo['additional_transportation'],
                'memory' => $clientSearchInfo['memory'],
                'incontinence' => $clientSearchInfo['incontinence'],
                'preference_for_the_nurse' => $clientSearchInfo['preference_for_the_nurse'],
                'hearing' => $clientSearchInfo['hearing'],
                'vision' => $clientSearchInfo['vision'],
                'areas_help' => $clientSearchInfo['areas_help'],
                'other_areas' => $clientSearchInfo['other_areas'],
                'one_or_regular' => $clientSearchInfo['one_or_regular'],
                'one_time_date' => Carbon::createFromDate($clientSearchInfo['one_time_date'])->format('Y-m-d'),
                'regular_time_start_date' => $clientSearchInfo['regular_time_start_date'],
                'regular_time_finish_date' => $clientSearchInfo['regular_time_finish_date'],
                'work_time_pref' => json_encode($clientSearchInfo['work_time_pref']),
            ]);

        if ($success) {
            return $success;
        } else {
            return false;
        }
    }
}
