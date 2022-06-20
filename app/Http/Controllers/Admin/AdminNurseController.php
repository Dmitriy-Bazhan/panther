<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\NurseResource;
use App\Models\Nurse;
use Illuminate\Http\Request;
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
//        $nurses = $this->nurseRepo->search(101);
        $nurses = $this->nurseRepo->search();
        return NurseResource::collection($nurses);
    }

    public function getNurseChats($id) {
        $data = $this->chatRepo->getNursePrivateChats($id);
        return response()->json(['success' => true, 'chats' => $data['chats'], 'clients' => $data['clients'],
            'haveNewMessages' => $data['haveNewMessages']]);
    }

    public function updateNurse(Request $request, $id) {
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
