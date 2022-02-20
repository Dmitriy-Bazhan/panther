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
    public function update(UpdateNurseRequest $request, $id)
    {
        $this->nurseRepo->update();

        return response()->json(['success' => 'OK']);
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

        if(!$file_path = $this->nurseRepo->uploadPhoto($request, $id)){
            return response()->json(['success' => false]);
        }

        Nurse::where('id', auth()->user()->entity_id)->update([
            'photo' => $file_path
        ]);

        return response()->json(['success' => $file_path, 'id' => $id]);
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
