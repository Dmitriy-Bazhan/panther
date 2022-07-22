<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AdminNurseController extends Controller
{
    protected $nurseRepo;
    protected $chatRepo;

    public function __construct(NurseRepository $nurseRepo, ChatRepository $chatRepo)
    {
        parent::__construct();
        $this->nurseRepo = $nurseRepo;
        $this->chatRepo = $chatRepo;
    }

    public function approveNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'yes',
                'change_info' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function dismissNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function getNurses()
    {
        $search = request()->get('search');
        request()->merge([
            'search' => $search
        ]);

        $nurses = $this->nurseRepo->search();
        return NurseResource::collection($nurses);
    }

    public function addNewNurse()
    {
        $nurse = json_decode(request()->post('nurse'), true);

        $rules = [
            'additional_info' => 'required',
            'available_care_range' => 'required',
            'description' => 'required',
            'email' => 'required|email',
            'experience' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'languages' => 'required',
            'last_name' => 'required',
            'multiple_bookings' => 'required',
            'one_or_regular' => 'required',
            'phone' => 'required',
            'pref_client_gender' => 'required',
            'provide_supports' => 'required',
            'ready_to_work' => 'required',
            'start_date_ready_to_work' => 'required',
            'type_of_learning' => 'required',
            'work_time_pref' => 'required',
            'zip_code' => 'required',
        ];

        $validator = Validator::make($nurse, $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

//        if (count(request()->allFiles()) > 0) {
//            $rules = [
//                'file' => 'required|file|mimes:jpeg,bmp,png'
//            ];
//
//            $validator = Validator::make(request()->allFiles(), $rules);
//            if ($validator->fails()) {
//                $errors = array_merge($errors, $validator->errors()->toArray());
//            }
//        } else {
//            Log::channel('app_logs')->error('NursesMyInformationController@updateFile File not come');
//            $errors = array_merge($errors, ['file' => 'File not come']);
//        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->nurseRepo->addNewNurse($nurse)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        return response()->json(['success' => true]);
    }

    public function getNurseChats($id)
    {
        $data = $this->chatRepo->getNursePrivateChats($id);
        return response()->json(['success' => true, 'chats' => $data['chats'], 'clients' => $data['clients'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function updateNurse(Request $request, $id)
    {
        $rules = [
            'id' => 'required|numeric',
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
            'entity.age' => 'required|numeric|min:18|max:100',
            'entity.available_care_range' => 'required|numeric|min:0|max:5',
            'entity.description' => 'required',
            'entity.gender' => 'required',
            'entity.experience' => 'required',
            'entity.multiple_bookings' => 'required',
            'entity.pref_client_gender' => 'required',

            'entity.languages.*.lang_id' => 'required',
            'entity.languages.*.level' => 'required',

            'entity.provide_supports' => 'required',
            'entity.one_or_regular' => 'required|in:one,regular,no_matter',
            'entity.start_date_ready_to_work' => 'required|date_format:Y-m-d',
        ];

        $validator = Validator::make($request->post('user'), $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->nurseRepo->update($id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        return response()->json(['success' => true]);
    }
}
