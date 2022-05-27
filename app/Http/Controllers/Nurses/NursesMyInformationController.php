<?php

namespace App\Http\Controllers\Nurses;

use App\Events\Admin\NurseAddNewProfile;
use App\Http\Repositories\NurseRepository;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class NursesMyInformationController extends Controller
{
    protected $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
        //
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

        $this->makeEventSendProfileToAdmin($id);
        return response()->json(['success' => true]);
    }

    public function updateFilesAndPhoto(Request $request, $id)
    {
        $rules = [
            'criminal_record' => 'required',
            'documentation_of_training' => 'required',
            'file' => 'required|file|mimes:jpeg,bmp,png'
        ];

        $nurses = $this->nurseRepo->search($id);
        $nurse = $nurses->first();

        $errors = [];
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
        if (!$this->nurseRepo->uploadDocuments($request, $nurse)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        if (!$this->nurseRepo->uploadPhoto($request, $id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => 'Cant upload']);
        }

        $this->makeEventSendProfileToAdmin($id);
        $certificates = json_decode($request->input('certificates'), true);
        $files = $request->file('certificates_files');
        return response()->json(['success' => true, 'files' => $files, 'certificates' => $certificates]);
    }

    public function removeCertificate() {
        $id = request()->post('id');

        if(!is_numeric($id)){
            //todo:: hmm
            return response()->json(['success' => false]);
        }

        if(!$nurseFile = NurseFile::where('id', $id)->first()){
            //todo:: hmm
            return response()->json(['success' => false]);
        }

        Storage::disk('public')->delete($nurseFile->file_path);
        Storage::disk('public')->delete($nurseFile->thumbnail_path);
        NurseFile::where('id', $id)->delete();

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
        try {
            broadcast(new NurseAddNewProfile())->toOthers();
        } catch (\Exception $ex) {

        };
    }
}
