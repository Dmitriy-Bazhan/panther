<?php


namespace App\Http\Repositories;


use App\Models\ClientSearchInfo;
use App\Models\User;

class ClientRepository
{
    protected $client;

    public function __construct(User $client)
    {
        $this->client = $client;
    }

    public function search(){

    }

    public function store($clientSearchInfo){

        if(!isset($clientSearchInfo['client_id'])) {
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
                'language' => $clientSearchInfo['language'],
                'language_level' => $clientSearchInfo['language_level'],
                'do_you_need_help_moving' => $clientSearchInfo['do_you_need_help_moving'],
                'additional_transportation' => $clientSearchInfo['additional_transportation'],
                'memory' => $clientSearchInfo['memory'],
                'incontinence' => $clientSearchInfo['incontinence'],
                'preference_for_the_nurse' => $clientSearchInfo['preference_for_the_nurse'],
                'hearing' => $clientSearchInfo['hearing'],
                'vision' => $clientSearchInfo['vision'],
                'areas_help' => $clientSearchInfo['areas_help'],
                'other_areas' => $clientSearchInfo['other_areas'],
            ]);

        return $success;
    }
}
