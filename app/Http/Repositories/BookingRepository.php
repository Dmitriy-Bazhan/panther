<?php


namespace App\Http\Repositories;


use App\Models\Booking;

class BookingRepository
{
    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function search($id = null, $status = null)
    {
        $bookings = $this->booking->newQuery();

        if (request()->filled('nurse_is_refuse_booking')) {
            $bookings->where('nurse_is_refuse_booking', request('nurse_is_refuse_booking'));
        }

        if (request()->filled('is_verification')) {
            $bookings->where('is_verification', request('is_verification'));
        }

        if(request()->filled('nurse_id')){
            $bookings->where('nurse_user_id', request('nurse_id'));
        }

        if(request()->filled('client_id')){
            $bookings->where('client_user_id', request('client_id'));
        }

        if (!is_null($id)) {
            $bookings->where('id', $id);
        }

        if (!is_null($status)) {
            $bookings->where('status', $status);
        }

        $bookings->with(
            ['time', 'client', 'nurse', 'alternative.time', 'payment']);

        return $bookings->paginate(config('settings.listing_paginate'));

    }


}
