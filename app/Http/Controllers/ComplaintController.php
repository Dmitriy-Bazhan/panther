<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ComplaintController extends Controller
{
    public function setClientComplaintOnNurse()
    {
        $complaint = request()->post('complaint');
        $nurseId = request()->post('nurse_id');

        if (is_null($complaint)) {
            return response()->json(['success' => true]);
        }

        if (is_null($nurseId) || !is_numeric($nurseId)) {
            Log::channel('app_logs')->error('ComplaintController@setClientComplaintOnNurse nurse id not valid');
            return response()->json(['success' => false]);
        }

        if (!User::find($nurseId)) {
            Log::channel('app_logs')->error('ComplaintController@setClientComplaintOnNurse nurse not exists');
            return response()->json(['success' => false]);
        }

        $new_complaint = Complaint::create([
            'client_user_id' => auth()->id(),
            'nurse_user_id' => $nurseId,
            'type' => 'nurse',
            'status' => 'unread',
            'complaint' => $complaint,
        ]);

        if ($new_complaint) {
            $this->makeNotification($nurseId);
        }

        return response()->json(['success' => true]);
    }

    public function setNurseComplaintOnClient()
    {
        $complaint = request()->post('complaint');
        $clientId = request()->post('client_id');

        if (is_null($complaint)) {
            return response()->json(['success' => true]);
        }

        if (is_null($clientId) || !is_numeric($clientId)) {
            Log::channel('app_logs')->error('ComplaintController@setClientComplaintOnNurse client id not valid');
            return response()->json(['success' => false]);
        }

        if (!User::find($clientId)) {
            Log::channel('app_logs')->error('ComplaintController@setClientComplaintOnNurse client not exists');
            return response()->json(['success' => false]);
        }

        $new_complaint = Complaint::create([
            'client_user_id' => $clientId,
            'nurse_user_id' => auth()->id(),
            'type' => 'client',
            'status' => 'unread',
            'complaint' => $complaint,
        ]);

        if ($new_complaint) {
            $this->makeNotification($clientId);
        }

        return response()->json(['success' => true]);
    }

    private function makeNotification($user_id)
    {
        $content = 'You have received a complaint';
        try {
            NotificationController::createNotification($user_id, 'complaint', $content);
        } catch (\Exception $exception) {

        }
        return true;
    }
}
