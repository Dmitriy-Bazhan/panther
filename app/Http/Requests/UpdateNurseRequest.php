<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNurseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->is_admin){
            return true;
        }
        if(auth()->user()->is_nurse && request()->post('user')['id'] == auth()->id()){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

//    public function failedValidation(Validator $validator) {

//        $errors = $validator->errors();
//        $messages = '';
//        foreach ($errors->all() as $message) {
//            $messages .= "<li>$message</li>";
//        }
//
//        abort(409, $messages);
//    }
}
