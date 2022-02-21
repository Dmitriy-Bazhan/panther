<?php

namespace App\Http\Controllers;

use App\Events\TestChatMessage;
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

    public function testSetMessage(Request $request)
    {
//        if (!$request->filled('message') || !$request->filled('user_id')) {
//            return response()->json([
//                'message' => 'No message to send'
//            ], 422);
//        }
//
//        ChatComment::create([
//            'user_id' => (int)$request->input('user_id'),
//            'message' => $request->input('message'),
//        ]);

        broadcast(new TestChatMessage($request->input('message'), $request->input('user_id'), $request->input('username')))->toOthers();

        return response()->json([], 200);

    }
}
