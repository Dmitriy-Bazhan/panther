<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = request()->post('data');
        if(!isset($data['id']) || !is_numeric($data['id'])){
            return response()->json(['success' => false]);
        }

        if(!User::find($data['id'])){
            //todo::hmm
            Log::debug('User not exists. Store methods in FeedbackController');
            return response()->json(['success' => false]);
        }

        if(!isset($data['type']) || !in_array($data['type'], ['nurse', 'client'])){
            return response()->json(['success' => false]);
        }

        If(!isset($data['feedback'])){
            return response()->json(['success' => false]);
        }

        if(is_null($data['feedback'])){
            return response()->json(['success' => true]);
        }

        $feedback = new Feedback();
        $feedback->creator_id = auth()->id();
        $feedback->target_user_id = $data['id'];
        $feedback->type = $data['type'];
        $feedback->description = $data['feedback'];
        if(!$feedback->save()){
            //todo::hmm
            Log::debug('Cant save feedback in store method in FeedbackController');
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        if(!is_numeric($id)){
            return response()->json(['success' => false]);
        }

        $feedbacks = Feedback::where('target_user_id', $id)->with('creator')->get();

        return response()->json(['success' => true, 'feedbacks' => $feedbacks]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
