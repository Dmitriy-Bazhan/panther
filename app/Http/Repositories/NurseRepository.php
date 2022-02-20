<?php

namespace App\Http\Repositories;

use App\Http\Requests\UploadNursePhotoRequest;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NurseRepository
{
    protected $nurse;

    public function __construct(Nurse $nurse)
    {
        $this->nurse = $nurse;
    }

    public function update() {

        return true;
    }

    public function uploadPhoto(Request $request, $id){
        $file_path = false;
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
        }
        return $file_path;
    }
}
