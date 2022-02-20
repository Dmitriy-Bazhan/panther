<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Nurse;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){

//        dd(auth()->user());

        $users = User::where('entity_type', 'nurse')->get();

            $data['data'] = $users;

        return view('test', $data);
    }
}
