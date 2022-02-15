<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        return view('main');
    }

    public function registerAndAuthenticate()
    {
        //todo:
    }

    public function nurseRegister()
    {
        return view('main');
    }

    public function clientRegister()
    {
        return view('main');
    }


}
