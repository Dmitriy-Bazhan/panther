<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ChatRepository;
use App\Http\Resources\BookingsResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class NurseBookingController extends Controller
{
    public $chatRepo;

    public function __construct(ChatRepository $chatRepo)
    {
        parent::__construct();

        $this->chatRepo = $chatRepo;
    }

    public function index()
    {
        $nurseId = 0;
        if(request()->filled('nurse_id') && is_numeric(request('nurse_id'))){
            $nurseId = request('nurse_id');
        }

        if(!User::find($nurseId)){
            //todo: hmmm
            abort(409);
        }

        $bookings = BookingsResource::collection(Booking::where('nurse_user_id', $nurseId)
            ->with('time', 'client', 'alternative')
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

    public function getPrivateChat($client_id = null){

        if(is_null($client_id) || !is_numeric($client_id)){
            //todo: hmm
            abort(409);
        }

        $chat = $this->chatRepo->getNursePrivateChatsWithClients($client_id);
        return response()->json(['success'=> true, 'chat' => $chat]);
    }
}
