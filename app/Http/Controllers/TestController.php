<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){

        $user = User::with('entity')->first();

        dd(auth()->user());

        dump($user->is_admin);
        dump($user->is_nurse);
        dump($user->is_client);

        dd($user);
        $admins = Admin::with('users')->get();

        dd($admins);

        dd('Stop');
    }
}
