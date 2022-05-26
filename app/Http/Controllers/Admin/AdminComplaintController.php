<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendWarningToUser;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminComplaintController extends Controller
{
    public function index() {
        $complaints = Complaint::with(['client', 'nurse'])->paginate(config('settings.listing_paginate'));
        return response()->json(['success' => true, 'complaints' => $complaints]);
    }

    public function changeStatusComplaint($id) {
        if(is_null($id) || !is_numeric($id)){
            Log::error('AdminComplaintController@changeStatusComplaint complaint id is not valid');
            return response()->json(['success' => false]);
        }

        if(!$complaint = Complaint::find($id)){
            Log::error('AdminComplaintController@changeStatusComplaint complaint not exists');
            return response()->json(['success' => false]);
        }

        if($complaint->status == 'unread'){
            Complaint::where('id', $id)->update(['status' => 'read']);
            $status = 'read';
        }else {
            Complaint::where('id', $id)->update(['status' => 'unread']);
            $status = 'unread';
        }

        return response()->json(['success' => true, 'status' => $status]);
    }

    public function sendMessageAdminToUser() {


        $userId = request()->post('user_id');
        $message = request()->post('message');

        $user = User::find($userId);

        if (env('MAIL_USE_QUEUE')) {
            Mail::mailer('smtp')->to($user->email)
                ->queue(new SendWarningToUser($user, $message));
        } else {
            Mail::mailer('smtp')->to($user->email)
                ->send(new SendWarningToUser($user, $message));
        }

        return response()->json(['success' => true ]);
    }
}
