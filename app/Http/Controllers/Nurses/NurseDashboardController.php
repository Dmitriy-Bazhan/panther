<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;
use App\Http\Repositories\NurseRepository;

class NurseDashboardController extends Controller
{
    protected $nurseRepo;

    public function __construct(NurseRepository $nurseRepo)
    {
        parent::__construct();

        $this->nurseRepo = $nurseRepo;
    }

    public function index()
    {
        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::all();
        $data['data']['additional_info_data'] = AdditionalInfoData::where('lang', auth()->user()->prefs->pref_lang)->get();
        $data['data']['have_new_message'] = PrivateChat::where('nurse_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('client_sent')
            ->first() !== null ? true : false ;
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
}
