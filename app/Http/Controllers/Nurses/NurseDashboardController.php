<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Models\NurseFile;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateNurseRequest;
use App\Http\Requests\UploadNursePhotoRequest;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['data']['provider_supports'] = ProvideSupport::all();
        return view('dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

        ];

        $nurses = $this->nurseRepo->search($id);
        $nurse = $nurses->first();

        if (!NurseFile::where([['nurse_id', $nurse->entity_id], ['file_type', 'criminal_record']])->first() &&
            !NurseFile::where([['nurse_id', $nurse->entity_id], ['file_type', 'documentation_of_training']])->first()) {
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


        if (!$this->nurseRepo->update($nurse)) {
            //todo:: hmm
            return response()->json(['success' => false, 'errors' => []]);
        }

        $this->makeEventSendProfileToAdmin();
        return response()->json(['success' => true]);
    }

    public function uploadPhoto(Request $request, $id)
    {
        $rules = [
            'file' => 'required|file|mimes:jpeg,jpg,jpe,bmp,png'
        ];

        $validator = Validator::make($request->file(), $rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if (!$file_paths = $this->nurseRepo->uploadPhoto($request, $id)) {
            return response()->json(['success' => false]);
        }

        Nurse::where('id', auth()->user()->entity_id)->update([
            'original_photo' => $file_paths['original_path'],
            'thumbnail_photo' => $file_paths['thumbnail_path'],
        ]);
        $this->makeEventSendProfileToAdmin();
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function makeEventSendProfileToAdmin()
    {
        //todo:email later
        //todo:make event
    }
}
