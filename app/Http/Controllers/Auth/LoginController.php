<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function logIn()
    {
        if(!auth()->check()){
            return view('main');
        }else{
            return redirect()->to('/');
        }
    }

    public function authenticate(Request $request)
    {
        $errors = [];
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'checkbox' => ['sometimes','boolean'],
        ]);

        $rememberMe = false;
        if($request->filled('checkbox') && $request->post('checkbox') == true){
            $rememberMe = true;
        }

        $credentials = [
            'email' => $request->post('email'),
            'password' => $request->post('password'),
        ];

        if (Auth::attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();

            return response()->json(['success' => true, 'dashboards' => auth()->user()->entity_type]);
        }

        $errors['email'] = 'The provided credentials do not match our records.';
        return response()->json(['success' => false, 'errors' => $errors]);
    }

    public function logOut()
    {
        Session::flush();
        Auth::logout();
        return response()->json(['success' => true]);
    }
}
