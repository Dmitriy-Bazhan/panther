<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function time() {
        return $this->hasOne('App\Models\BookingTime', 'booking_id', 'id');
    }

    public function client() {
        return $this->hasOne('App\Models\User', 'id', 'client_user_id');
    }

    public function nurse() {
        return $this->hasOne('App\Models\User', 'id', 'nurse_user_id');
    }

    public function alternative(){
        return $this->hasOne('App\Models\AlternativeBooking', 'booking_id', 'id');
    }
}
