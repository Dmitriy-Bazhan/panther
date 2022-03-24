<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public function time() {
        return $this->hasMany('App\Models\BookingTime', 'booking_id', 'id');
    }
}
