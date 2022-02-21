<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Models\Nurse;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'user.id' => 'required|numeric',
            'user.email' => 'required|email',
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.phone' => 'required',
            'user.zip_code' => 'required',
            'user.entity.age' => 'required|numeric|min:18|max:100',
            'user.entity.available_care_range' => 'required|numeric|min:1|max:5',
            'user.entity.description' => 'required',
            'user.entity.gender' => 'required',
            'user.entity.experience' => 'required',
            'user.entity.multiple_bookings' => 'required',
            'user.entity.pref_client_gender' => 'required',

            'user.entity.languages.*.lang' => 'required',
            'user.entity.languages.*.level' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        $nurses = $this->nurseRepo->search(request('user.id'));
        $nurse = $nurses->first();

        $nursesUp = $this->nurseRepo->update($nurse->id);



        return response()->json(['success' => true, 'user' => $nursesUp]);
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

        if(!$file_paths = $this->nurseRepo->uploadPhoto($request, $id)){
            return response()->json(['success' => false]);
        }

        Nurse::where('id', auth()->user()->entity_id)->update([
            'original_photo' => $file_paths['original_path'],
            'thumbnail_photo' => $file_paths['thumbnail_path'],
        ]);

        return response()->json(['success' => $file_paths['thumbnail_path'], 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
