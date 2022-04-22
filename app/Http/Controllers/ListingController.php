<?php

namespace App\Http\Controllers;

use App\Events\PrivateChat\ClientNurseSentMessage;
use App\Events\PrivateChat\NurseHaveNewMessage;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NurseResource;
use App\Models\ClientSearchInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    protected $nursesRepo;
    protected $clientsRepo;
    protected $chatRepo;

    public function __construct(NurseRepository $nursesRepo, ClientRepository $clientsRepo, ChatRepository $chatRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
        $this->clientsRepo = $clientsRepo;
        $this->chatRepo = $chatRepo;
    }

    public function getClientSearchInfo()
    {
        if (!$clientSearchInfo = ClientSearchInfo::where('client_id', auth()->user()->entity->id)->first()) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'clientSearchInfo' => $clientSearchInfo]);
    }

    public function getPrivateChats($nurse_id = null){
        if(is_null($nurse_id) || !is_numeric($nurse_id)){
            //todo: logs
            return abort(409);
        }

        $chat = $this->chatRepo->getClientPrivateChatsWithNurse($nurse_id);
        return response()->json(['success' => true, 'chat' => $chat]);

    }

    public function getNursesToListing()
    {
        if (!auth()->user()->is_client) {
            return abort(409);
        }

        $clientSearchInfo = request('clientSearchInfo');
        $rules = [
            'for_whom' => 'required|in:to_me,for_a_relative',
            'name' => 'required',
            'last_name' => 'required',
            'age_range' => 'required|in:0-20,20-40,40-60,60-70,70-80,80-90,90+',
            'provider_supports' => 'required', //filter
            'disease' => 'sometimes',
            'other_disease' => 'sometimes',
            'degree_of_care_available' => 'required|in:0,1,2,3,4,5',  //filter
            'languages' => 'required',         //filter
            'do_you_need_help_moving' => 'required',
            'additional_transportation' => 'required',
            'memory' => 'required',
            'incontinence' => 'required',
            'preference_for_the_nurse' => 'required|in:male,female,no_matter', //filter
            'hearing' => 'required',
            'vision' => 'required',
            'areas_help' => 'required',
            'other_areas' => 'sometimes',
            'one_or_regular' => 'required|in:one,regular',  //filter
        ];

        $validator = Validator::make($clientSearchInfo, $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if(isset($clientSearchInfo['regular_time_range']) && count($clientSearchInfo['regular_time_range']) > 0){
            $clientSearchInfo['regular_time_start_date'] = Carbon::createFromDate($clientSearchInfo['regular_time_range'][0])->format('Y-m-d');
            $clientSearchInfo['regular_time_finish_date'] = Carbon::createFromDate($clientSearchInfo['regular_time_range'][1])->format('Y-m-d');
        }

        if (!$this->clientsRepo->store($clientSearchInfo)) {
            //todo: hmm
            return abort(409);
        }

        $clientSearchInfo['language'] = [];
        $clientSearchInfo['language_level'] = [];

        foreach ($clientSearchInfo['languages'] as $language){
            $clientSearchInfo['language'][] = $language['val'];
            $clientSearchInfo['language_level'][] = $language['level'];
        }




        request()->merge([
            'is_approved' => 'yes',
            'provider_supports' => $clientSearchInfo['provider_supports'],
            'degree_of_care_available' => $clientSearchInfo['degree_of_care_available'],
            'language' => $clientSearchInfo['language'],
            'language_level' => $clientSearchInfo['language_level'],                      //filter
            'preference_for_the_nurse' => $clientSearchInfo['preference_for_the_nurse'],
            'one_or_regular' => $clientSearchInfo['one_or_regular'],
            'one_time_date' => $clientSearchInfo['one_time_date'],
            'regular_time_start_date' => $clientSearchInfo['regular_time_start_date'],
            'regular_time_finish_date' => $clientSearchInfo['regular_time_finish_date'],
            'work_time_pref' => $clientSearchInfo['work_time_pref'],
        ]);

        $nurses = NurseResource::collection($this->nursesRepo->search())->response()->getData();

        return response()->json(['success' => true, 'nurses' => $nurses]);
    }

    public function sendPrivateMessage()
    {
        $nurse_id = null;
        if (request()->filled('nurse_id') && is_numeric(request('nurse_id'))) {
            $nurse_id = request('nurse_id');
        }

        $privateMessage = null;
        if (request()->filled('privateMessage') && request('privateMessage') !== '') {
            $privateMessage = request('privateMessage');
        }

        $client_id = auth()->id();
        $user_name = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        if (!$result = $this->chatRepo->saveMessageClientToNurse($nurse_id, $client_id, $privateMessage, $user_name)) {
            //todo: cant save message client to burse
            return abort(409);
        }

        broadcast(new ClientNurseSentMessage($result));
        broadcast(new NurseHaveNewMessage($result))->toOthers();
        return response()->json(['success' => $result]);
    }
}
