<?php

namespace App\Http\Controllers\Nurses;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingsResource;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class NurseBookingController extends Controller
{

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

        $bookings = BookingsResource::collection(Booking::where('nurse_user_id', $nurseId)->with('time', 'client')->get());
        return response()->json(['success' => true, 'bookings' => $bookings]);
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
