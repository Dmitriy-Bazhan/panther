<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternativeBooking extends Model
{
    use HasFactory;

    public function time() {
        return $this->hasMany('App\Models\AlternativeBookingTime', 'alternative_booking_id', 'id');
    }
}
