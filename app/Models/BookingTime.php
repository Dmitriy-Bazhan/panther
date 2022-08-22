<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTime extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
        'id',
        'booking_id',
    ];

    protected $fillable = [
        'booking_id', 'time_interval', 'time',
    ];
}
