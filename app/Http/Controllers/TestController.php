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

        $user = auth()->user();
        dd($user->provideSupports);

        $nurse = Nurse::where('id', auth()->user()->entity_id)->with('user')->first();
        dd($nurse);

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
