<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'hourly_payment',
        'weekend_surcharge',
        'weekend_surcharge_payment',
        'holiday_surcharge',
        'holiday_surcharge_payment',
        'fare_surcharge',
        'fare_surcharge_payment',
    ];
}
