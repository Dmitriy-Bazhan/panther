<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\AdditionalInfo;
use App\Models\AdditionalInfoData;
use App\Models\Booking;
use App\Models\PrivateChat;
use App\Models\ProvideSupport;
use App\Models\User;
use Illuminate\Http\Request;

class ClientBookingsController extends Controller
{
    public $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $clientId = 0;
        if(request()->filled('client_id') && is_numeric(request('client_id'))){
            $clientId = request('client_id');
        }

        if(!User::find($clientId)){
            //todo: hmmm
            abort(409);
        }

        $bookings = BookingsResource::collection(Booking::where('client_user_id', $clientId)
            ->with('time', 'nurse', 'alternative')
            ->get());
        return response()->json(['success' => true, 'bookings' => $bookings]);
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
