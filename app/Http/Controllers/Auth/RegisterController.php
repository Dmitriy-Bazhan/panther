<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\HearAboutUs;
use App\Models\Nurse;
use App\Models\NursePrice;
use App\Models\User;
use App\Models\UserPref;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use phpDocumentor\Reflection\Utils;


class RegisterController extends Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();

        $data['hear_about_us'] = HearAboutUs::where('is_show', 'yes')->with('data')->get();
        $this->data = $data;
    }

    public function register()
    {
        if(!auth()->check()){
            return view('main', ['data' => $this->data]);
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
            return view('main', ['data' => $this->data]);
        }else{
            return redirect()->to('/');
        }
    }

    public function clientRegister()
    {
        if(!auth()->check()){
            return view('main',  ['data' => $this->data]);
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
            'hear_about_us' => 'sometimes',
            'hear_about_us_other' => 'sometimes',
            'locale' => 'required|in:en,de'
        ];

        $messages = [
            'first_name.required' => __('errors.first_name'),
            'last_name.required' => __('errors.last_name'),
            'phone.required' => __('errors.phone'),
            'zip_code.required' => __('errors.zip_code'),
            'email.required' => __('errors.email_required'),
            'email.email' => __('errors.email_email'),
            'email.unique' => __('errors.email_unique'),
            'password.required' => __('errors.password_required'),
            'password.min' => __('errors.password_min'),
            'password.confirmed' => __('errors.password_confirmed'),
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if ($user = $this->createClient($data)) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                event(new Registered($user));

                return response()->json(['success' => true]);
            }
        } else {
            Log::channel('app_logs')->error('Can\'t create client in Register Controller');
            return response()->json(['success' => false]);
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
        $user->hear_about_us = $data['hear_about_us'];
        $user->hear_about_us_other = $data['hear_about_us_other'];

        if ($user->save()) {

            $userId = $user->id;
            $userPrefs = new UserPref();
            $userPrefs->user_id = $userId;
            $userPrefs->pref_lang = $data['locale'];
            $userPrefs->save();

            request()->merge([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            return $user;
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
            'hear_about_us' => 'sometimes',
            'hear_about_us_other' => 'sometimes',
            'locale' => 'required|in:en,de'
        ];

        $messages = [
            'first_name.required' => __('errors.first_name'),
            'last_name.required' => __('errors.last_name'),
            'phone.required' => __('errors.phone'),
            'zip_code.required' => __('errors.zip_code'),
            'email.required' => __('errors.email_required'),
            'email.email' => __('errors.email_email'),
            'email.unique' => __('errors.email_unique'),
            'password.required' => __('errors.password_required'),
            'password.min' => __('errors.password_min'),
            'password.confirmed' => __('errors.password_confirmed'),
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success' => false, 'errors' => $errors]);
        }

        if ($user = $this->createNurse($data)) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                event(new Registered($user));
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
        $user->hear_about_us = isset($data['hear_about_us']) ? $data['hear_about_us'] : null;
        $user->hear_about_us_other = $data['hear_about_us_other'];

        if ($user->save()) {
            $userId = $user->id;
            $userPrefs = new UserPref();
            $userPrefs->user_id = $userId;
            $userPrefs->pref_lang = $data['locale'];
            $userPrefs->save();

            $nursePrice = new NursePrice();
            $nursePrice->nurse_id = $newNurseId;
            $nursePrice->save();

            request()->merge([
                'email' => $data['email'],
                'password' => $data['password'],
            ]);


            return $user;
        } else {
            //todo: I will ask my comrades for best practices for logs and errors
            return false;
        }
    }
}
