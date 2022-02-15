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
        return view('main');
    }

    public function authenticate(Request $request)
    {
        $errors = [];
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['success' => true]);
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
