<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'client_user_id',
        'nurse_user_id',
        'date',
        'sum',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'id');
    }
}
