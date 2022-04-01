<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\NurseRepository;
use App\Http\Resources\ClientResource;
use App\Http\Resources\NurseResource;
use App\Models\AdditionalInfo;
use App\Models\HearAboutUs;
use App\Models\Nurse;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected $nursesRepo;
    protected $clientRepo;

    public function __construct(NurseRepository $nursesRepo, ClientRepository $clientRepo)
    {
        parent::__construct();
        $this->nursesRepo = $nursesRepo;
        $this->clientRepo = $clientRepo;
    }

    public function index()
    {
        $data['data']['incoming_new_user_info'] = null;
        if (Nurse::where('info_is_full', 'yes')->where('is_approved', 'no')->first() || Nurse::where('change_info', 'yes')->first()) {
            $data['data']['incoming_new_user_info'] = true;
        }

        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::with('data')->get();
        return view('dashboard', $data);
    }

    public function approveNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'yes',
                'change_info' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
    }

    public function dismissNurse()
    {
        if (request()->filled('id') && is_numeric(request('id'))) {
            Nurse::where('id', request('id'))->update([
                'is_approved' => 'no',
            ]);
        } else {
            abort(409);
        }

        return response()->json(['id' => request('id')]);
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

    public function getNurses()
    {
        $nurses = $this->nursesRepo->search();
        return NurseResource::collection($nurses);
    }

    public function getClients()
    {
        $clients = $this->clientRepo->search();
        return response()->json(['clients' => $clients]);
    }

    public function hearAboutUs()
    {
        $hearAboutUs = HearAboutUs::with('data')->get();
        return response()->json(['hear_about_us' => $hearAboutUs]);
    }

    public function changeHearAboutUsShow($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['success' => false]);
        }

        if (!$hearAboutUs = HearAboutUs::where('id', $id)->first()) {
            return response()->json(['success' => false]);
        }

        $is_show = 'yes';
        if ($hearAboutUs->is_show == 'yes') {
            $is_show = 'no';
        }

        $hearAboutUs->is_show = $is_show;
        if (!$hearAboutUs->save()) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true, 'is_show' => $is_show]);
    }
}
