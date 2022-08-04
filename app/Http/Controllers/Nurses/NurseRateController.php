<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use App\Models\Rate;
use Illuminate\Http\Request;

class NurseRateController extends Controller
{
    public function getFeedbackAndRatings() {
        $feedbacks = Feedback::where('target_user_id', auth()->id())->with('creator')->paginate(config('settings.listing_paginate'));
        $rates = Rate::where('user_id', auth()->id())->with('creator')->paginate(config('settings.listing_paginate'));

        $feedbacks = FeedbackResource::collection($feedbacks)->response()->getData();

        return response()->json(['success' => true, 'feedbacks' => $feedbacks, 'rates' => $rates ]);
    }
}
