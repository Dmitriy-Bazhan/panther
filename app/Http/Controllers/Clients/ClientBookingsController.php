<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class ClientBookingsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['data']['provider_supports'] = ProvideSupport::all();
        $data['data']['additional_info'] = AdditionalInfo::all();
        $data['data']['additional_info_data'] = AdditionalInfoData::where('lang', auth()->user()->prefs->pref_lang)->get();
        $data['data']['have_new_message'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('nurse_sent')
            ->first() !== null ? true : false;
        $data['data']['last_unread_messages'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('nurse_sent', 'yes')
            ->orderByDesc('created_at')->get()->groupBy('nurse_user_id');
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
        return $this->index();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
