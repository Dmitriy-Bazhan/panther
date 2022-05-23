<?php

namespace App\Http\Controllers;

use App\Http\Resources\RateResource;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RateController extends Controller
{
    public function index() {
        $rates = Rate::where('target_user_id', auth()->id())->paginate(config('settings.listing_paginate'));
        $responseRates = RateResource::collection($rates)->response()->getData();
        return response()->json(['success' => true, 'rates' => $responseRates]);
    }

    public function setUserRate()
    {
        if (!request()->filled('new_rate')) {
            return response()->json(['success' => false]);
        }
        $data = request('new_rate');

        $result = Rate::updateOrCreate(
            ['user_id' => $data['user_id'], 'creator_id' => auth()->id()],
            ['rate' => $data['new_rate']]
        );

        if(!$result){
            //todo::hmm
            Log::error('Cant create/update Rate');
        }

        $newRate = new \stdClass();
        $rate = Rate::where('user_id', $data['user_id'])->get();

        $newRate->count = count($rate);

        $average = $rate->sum(function ($value) {
                return $value->rate;
            }) / $newRate->count;

        $newRate->round = round ($average);
        $newRate->real = round ($average , 2);

        return response()->json(['success' => true, 'newRate' => $newRate]);
    }
}
