<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
//        if (auth()->check()) {
//            app()->setLocale(auth()->user()->prefs->pref_lang);
//        } else if (isset(request()->post('data')['locale'])) {
//            app()->setLocale(request()->post('data')['locale']);
//        }
    }
}
