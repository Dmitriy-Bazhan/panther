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

    public function uploadPhoto(UploadNursePhotoRequest $request, $id)
    {
        $f = '';
        $this->nurseRepo->uploadPhoto();

        if ($request->file()) {
            $file_name = 'user_' . $id . '_' . $request->file->getClientOriginalName();
            $directory_name = 'user_' . $id . '/photo';
            $existedPhotos = Storage::disk('public')->files($directory_name);
            if(count($existedPhotos) > 0){
                Storage::disk('public')->deleteDirectory($directory_name);
                $file_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
            }else{
                $file_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
            }

            Nurse::where('id', auth()->user()->entity_id)->update([
                'photo' => $directory_name . '/' .$file_name
            ]);
        }


        return response()->json(['success' => $file_name, 'id' => $id]);
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
