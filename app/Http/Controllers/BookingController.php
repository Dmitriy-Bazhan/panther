<?php

namespace App\Http\Controllers;

use App\Http\Repositories\NurseRepository;
use App\Models\AdditionalInfo;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
//        $data = [];
//        if (auth()->check()) {
//            $data['data']['provider_supports'] = ProvideSupport::all();
//            $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
//        }
//        return view('main', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $data = [];
        if (auth()->check()) {
            $data['data']['provider_supports'] = ProvideSupport::all();
            $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
        }

        $nurses = $this->nurseRepo->search($id);
        $data['data']['nurse'] = $nurses->first();
        return view('main', $data);
    }

    public function edit($id)
    {

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
