<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function banUser($id)
    {
        if (!is_numeric($id)) {
            Log::channel('app_logs')->error('AdminController@banUser user id is not valid');
            return response()->json(['success' => false]);
        }

        if(!User::find($id)){
            Log::channel('app_logs')->error('AdminController@banUser user not exists');
            return response()->json(['success' => false]);
        }

        User::where('id', $id)->update([
            'banned' => 'yes',
        ]);

        return response()->json(['success' => true]);
    }

    public function dismissBanUser($id)
    {
        if (!is_numeric($id)) {
            Log::channel('app_logs')->error('AdminController@dismissBanUser user id is not valid');
            return response()->json(['success' => false]);
        }

        if(!User::find($id)){
            Log::channel('app_logs')->error('AdminController@dismissBanUser user not exists');
            return response()->json(['success' => false]);
        }

        User::where('id', $id)->update([
            'banned' => 'no',
        ]);

        return response()->json(['success' => true]);
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
