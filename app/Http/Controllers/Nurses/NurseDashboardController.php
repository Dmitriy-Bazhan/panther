<?php

namespace App\Http\Controllers\Nurses;

use App\Events\Admin\NurseAddNewProfile;
use App\Http\Controllers\Controller;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;
use App\Http\Repositories\NurseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NurseDashboardController extends Controller
{
    protected $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::all();
        $data['data']['additional_info_data'] = AdditionalInfoData::where('lang', auth()->user()->prefs->pref_lang)->get();
        return view('dashboard', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
//        return response()->json(['success' => true, 'request' => $request->allFiles()]);
        $rules = [
            'id' => 'required|numeric',
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
            'entity.age' => 'required|numeric|min:18|max:100',
            'entity.available_care_range' => 'required|numeric|min:1|max:5',
            'entity.description' => 'required',
            'entity.gender' => 'required',
            'entity.experience' => 'required',
            'entity.multiple_bookings' => 'required',
            'entity.pref_client_gender' => 'required',

            'entity.languages.*.lang' => 'required',
            'entity.languages.*.level' => 'required',

            'entity.provide_supports' => 'required',
        ];

        $validator = Validator::make(json_decode($request->all('user')['user'], true), $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        $rules = [
            'criminal_record' => 'required',
            'documentation_of_training' => 'required',
            'file' => 'required|file|mimes:jpeg,bmp,png'
        ];

        $nurses = $this->nurseRepo->search($id);
        $nurse = $nurses->first();

        if ($nurse->entity->files->where('file_type', 'criminal_record')->count() == 0
                && $nurse->entity->files->where('file_type', 'documentation_of_training')->count() == 0) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }

        $rules = [
            'file' => 'required|file|mimes:jpeg,bmp,png'
        ];

        if ($request->file('file') || is_null($nurse->entity->original_photo)) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->nurseRepo->update($nurse)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        if (!$this->nurseRepo->uploadDocuments($request, $nurse)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        if (!$this->nurseRepo->uploadPhoto($request, $id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => 'Cant upload']);
        }

        $this->makeEventSendProfileToAdmin($id);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        //
    }

    private function makeEventSendProfileToAdmin($id)
    {
        //todo:email later

        //todo:check, are pusher is work?
        try{
            broadcast(new NurseAddNewProfile())->toOthers();
        }catch (\Exception $ex){

        };

    }
}
