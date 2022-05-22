<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminComplaintController extends Controller
{
    public function index() {
        $complaints = Complaint::with(['client', 'nurse'])->paginate(config('settings.listing_paginate'));
        return response()->json(['success' => true, 'complaints' => $complaints]);
    }
}
