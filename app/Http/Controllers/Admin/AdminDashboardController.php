<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\NurseRepository;
use App\Models\AdditionalInfo;
use App\Models\Nurse;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $nursesRepo;

    public function __construct(NurseRepository $nursesRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
    }

    public function index()
    {
        $data['data']['incoming_new_user_info'] = null;
        if(Nurse::where('info_is_full', 'yes')->first() || Nurse::where('change_info', 'yes')->first()){
            $data['data']['incoming_new_user_info'] = true;
        }

        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::with('data')->get();

        return view('dashboard', $data);
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
        //
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

    public function settings(){
        return view('dashboard');
    }

    public function getNurses(){
        request()->merge([
            'only_full_info' => true
        ]);

        $nurses = $this->nursesRepo->search();

        $data['nurses'] = $nurses;
        return response()->json($data);
    }
}
