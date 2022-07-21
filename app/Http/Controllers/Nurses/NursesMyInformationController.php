<?php

namespace App\Http\Controllers\Nurses;

use App\Events\Admin\NurseAddNewProfile;
use App\Http\Repositories\NurseRepository;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function update(Request $request, $id)
    {

        $user = json_decode(request()->post('user'), true);

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
            'entity.start_date_ready_to_work' => 'required|date',
        ];

        $validator = Validator::make($user, $rules);

        $errors = [];
        if ($validator->fails()) {
            $errors = array_merge($errors, $validator->errors()->toArray());
        }

        $rules = [
            'file' => 'required|file|mimes:jpeg,bmp,png'
        ];

        if ($request->file('file') || is_null(User::find($id)->entity->original_photo)) {
            $validator = Validator::make($request->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$this->nurseRepo->uploadPhoto($request, $id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => 'Cant upload']);
        }

        if (!$this->nurseRepo->update($id)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        $this->makeEventSendProfileToAdmin($id);

        return response()->json(['success' => true, 'nurse' => User::find($id)]);
    }

    public function updateFile($nurse_id)
    {
        if (!$nurse = User::find($nurse_id)) {
            Log::channel('app_logs')->error('NursesMyInformationController@updateFile User not exists');
            return response()->json(['success' => false, 'errors' => 'User not exists']);
        }

        $errors = [];
        $post = [];
        if (request()->filled('info')) {
            $post = json_decode(request()->post('info'), true);
        } else {
            Log::channel('app_logs')->error('NursesMyInformationController@updateFile File info not exists');
            $errors = array_merge($errors, ['info' => 'File info not exists']);
        }

        if (count(request()->allFiles()) > 0) {
            $rules = [
                'file' => 'required|file|mimes:jpeg,bmp,png'
            ];

            $validator = Validator::make(request()->allFiles(), $rules);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        } else {
            Log::channel('app_logs')->error('NursesMyInformationController@updateFile File not come');
            $errors = array_merge($errors, ['file' => 'File not come']);
        }

        if (!is_null($post) && count($post) > 0) {
            $rules = [
                'title' => 'required',
                'date' => 'required|date',
                'place' => 'required',
                'type' => 'required',
            ];

            $validator = Validator::make($post, $rules);

            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors()->toArray());
            }
        } else {
            Log::channel('app_logs')->error('NursesMyInformationController@updateFile Info not come');
            $errors = array_merge($errors, ['file' => 'Info not come']);
        }

        if (count($errors) > 0) {
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        $success = $this->nurseRepo->uploadFile($nurse, $post);

        if($success){
            $nurse = User::find($nurse_id);
        }

        return response()->json(['success' => $success, 'files' => $nurse->entity->files]);
    }

    public function removeFile($nurse_id)
    {
        $success = true;
        $file_id = request()->post('file_id');
        if(!is_numeric($nurse_id) || !is_numeric($file_id)){
            $success = false;
            Log::channel('app_logs')->error('NursesMyInformationController@removeFile nurse_id or file_id is not numeric');
        }

        if (!$nurse = User::find($nurse_id)) {
            Log::channel('app_logs')->error('NursesMyInformationController@updateFile User not exists');
            return response()->json(['success' => false, 'errors' => 'User not exists']);
        }

        $file = $nurse->entity->files->where('id', $file_id)->first();

        Storage::disk('public')->delete($file->file_path);
        Storage::disk('public')->delete($file->thumbnail_path);

        $success = NurseFile::where('id', $file_id)->where('nurse_id', $nurse->entity->id)->delete();

        if($success){
            $nurse = User::find($nurse_id);
        }

        return response()->json(['success' => $success, 'files' => $nurse->entity->files]);
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

        if ($request->file('file') || is_null(User::find($id)->entity->original_photo)) {
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

    public function removeCertificate()
    {
        $id = request()->post('id');

        if (!is_numeric($id)) {
            //todo:: hmm
            return response()->json(['success' => false]);
        }

        if (!$nurseFile = NurseFile::where('id', $id)->first()) {
            //todo:: hmm
            return response()->json(['success' => false]);
        }

        Storage::disk('public')->delete($nurseFile->file_path);
        Storage::disk('public')->delete($nurseFile->thumbnail_path);
        NurseFile::where('id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
