<?php

use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Lang;
use App\Models\ProvideSupport;
use App\Models\TypesOfLearning;

if(!function_exists('siteData')){
    function siteData(){
        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
        $data['data']['additional_info_data'] = AdditionalInfoData::where('lang', auth()->user()->prefs->pref_lang)->get();
        $data['data']['type_of_learning'] = TypesOfLearning::with(['data' => function($query) {
            return $query->where('lang', auth()->user()->prefs->pref_lang);
        }])->get();
        $data['data']['languages'] = Lang::all();
        $data['data']['settings'] = config('settings');

        $timeIntervals = \App\Models\TimeInterval::all();
        $timeIntervals->map(function ($value){
            $value->value = json_decode($value->value, true);
        });
        $data['data']['time_intervals'] = $timeIntervals;
        return $data;
    }
}

if (!function_exists('get_prefix')) {
    function get_prefix()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            $locale = substr($_SERVER['REQUEST_URI'], 0, 3);

            if ($locale == '/en') {
                app()->setLocale('en');
                $prefix = $locale;
            } else {
                app()->setLocale('de');
                $prefix = '';
            }

            return $prefix;
        }
        return;
    }
}
