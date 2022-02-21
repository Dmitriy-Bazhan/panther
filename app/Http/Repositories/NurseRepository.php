<?php

namespace App\Http\Repositories;

use App\Http\Requests\UploadNursePhotoRequest;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;

class NurseRepository
{
    protected $user;

    public function __construct(User $nurse)
    {
        $this->user = $nurse;
    }

    public function search($id = null){

        $user = $this->user->newQuery();
        $user->where('entity_type', 'nurse');

        if(!is_null($id)){
            $user->where('id', $id);
        }

        return $user->paginate(10);
    }


    public function update($user_id)
    {
        $user = User::find($user_id);


        return $user;
    }

    public function uploadPhoto(Request $request, $id)
    {

        if ($request->file()) {
            $file_name = 'original_photo_user_'.$id.'_'.$request->file->getClientOriginalName();
            $thumbnail_name = 'thumbnail_photo_user_'.$id.'_'.$request->file->getClientOriginalName();
            $directory_name = 'user_'.$id.'/photo';
            $existedPhotos = Storage::disk('public')->files($directory_name);
            if (count($existedPhotos) > 0) {
                Storage::disk('public')->deleteDirectory($directory_name);
                $original_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
                $thumbnail_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $thumbnail_name);
            } else {
                $original_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $file_name);
                $thumbnail_path = Storage::disk('public')->putFileAs($directory_name, $request->file('file'), $thumbnail_name);
            }

            //make thumbnail or avatar
            $img = Image::make('storage/' .$thumbnail_path)->resize(50, 50, function ($constraint){
                $constraint->aspectRatio();
            });

            $img->save();
        } else {
            return false;
        }
        return ['original_path' => $original_path, 'thumbnail_path' => $thumbnail_path];
    }
}
