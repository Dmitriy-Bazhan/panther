<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $data = request()->post('data');
        if (!isset($data['id']) || !is_numeric($data['id'])) {
            return response()->json(['success' => false]);
        }

        if (!User::find($data['id'])) {
            //todo::hmm
            Log::channel('app_logs')->error('User not exists. Store methods in FeedbackController');
            return response()->json(['success' => false]);
        }

        if (!isset($data['type']) || !in_array($data['type'], ['nurse', 'client'])) {
            return response()->json(['success' => false]);
        }

        If (!isset($data['feedback'])) {
            return response()->json(['success' => false]);
        }

        if (is_null($data['feedback'])) {
            return response()->json(['success' => true]);
        }

        $feedback = Feedback::create([
            'creator_id' => auth()->id(),
            'target_user_id' => $data['id'],
            'type' => $data['type'],
            'description' => $data['feedback'],
        ]);

        if (!$feedback) {
            //todo::hmm
            Log::channel('app_logs')->error('Cant save feedback in store method in FeedbackController');
            return response()->json(['success' => false]);
        }

        $content = 'You have new feedback';
        try {
            NotificationController::createNotification($data['id'], 'feedback', $content);
        } catch (\Exception $exception) {

        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        $feedbacks = Feedback::where('target_user_id', $id)->with('creator')->get();

        if ($feedbacks->count() > 0 && request()->ajax()) {
            return response()->json(['success' => true, 'feedbacks' => $feedbacks]);
        } else {
            return response()->json(['success' => false]);
        }

    }
}
