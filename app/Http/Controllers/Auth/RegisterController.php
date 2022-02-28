<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Nurse;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    public function register()
    {
        if(!auth()->check()){
            return view('main');
        }else{
            return redirect()->to('/');
        }
    }

    public function registerAndAuthenticate()
    {
        //todo:
    }

    public function nurseRegister()
    {
        if(!auth()->check()){
            return view('main');
        }else{
            return redirect()->to('/');
        }
    }

    public function clientRegister()
    {
        if(!auth()->check()){
            return view('main');
        }else{
            return redirect()->to('/');
        }
    }

    public function clientRegistration(Request $request)
    {
        $data = $request->post('data');
        //todo:make need rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if ($this->createClient($data)) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json(['success' => true]);
            }
        } else {
            //todo: I will ask my comrades for best practices for logs and errors
            return abort(500);
        }
    }

    public function createClient(array $data)
    {
        $newClient = new Client();
        if (!$newClient->save()) {
            //todo: I will ask my comrades for best practices for logs and errors
            return false;
        }

        $newClientId = $newClient->id;

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->zip_code = $data['zip_code'];
        $user->password = Hash::make($data['password']);
        $user->entity_id = $newClientId;
        $user->entity_type = 'client';

        if ($user->save()) {

            $userId = $user->id;
            $userPrefs = new UserPref();
            $userPrefs->user_id = $userId;
            $userPrefs->pref_lang = 'de';
            $userPrefs->save();

            request()->merge([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            event(new Registered($user));
            return true;
        } else {
            //todo: I will ask my comrades for best practices for logs and errors
            return false;
        }
    }

    public function nurseRegistration(Request $request)
    {
        $data = $request->post('data');
        //todo:make need rules
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'zip_code' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if ($this->createNurse($data)) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json(['success' => true]);
            }
        } else {
            //todo: I will ask my comrades for best practices for logs and errors
            return abort(500);
        }
    }

    public function createNurse(array $data)
    {
        $newNurse = new Nurse();
        if (!$newNurse->save()) {
            //todo: I will ask my comrades for best practices for logs and errors
            return false;
        }

        $newNurseId = $newNurse->id;

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->zip_code = $data['zip_code'];
        $user->password = Hash::make($data['password']);
        $user->entity_id = $newNurseId;
        $user->entity_type = 'nurse';

        if ($user->save()) {
            $userId = $user->id;
            $userPrefs = new UserPref();
            $userPrefs->user_id = $userId;
            $userPrefs->pref_lang = 'de';
            $userPrefs->save();

            request()->merge([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            event(new Registered($user));
            return true;
        } else {
            //todo: I will ask my comrades for best practices for logs and errors
            return false;
        }
    }
}
