<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Lang;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = siteData();

        $data['data']['have_new_message'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->whereNotNull('nurse_sent')
            ->first() !== null ? true : false;
        $data['data']['last_unread_messages'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('nurse_sent', 'yes')
            ->orderByDesc('created_at')->get()->groupBy('nurse_user_id');
        $data['data']['count_of_unread_messages'] = PrivateChat::where('client_user_id', auth()->id())
            ->where('status', 'unread')
            ->where('nurse_sent', 'yes')
            ->count();

        return view('dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
