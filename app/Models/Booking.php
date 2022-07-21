<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'nurse_user_id',
	'client_user_id',
	'hourly_price',
	'suggested_price_per_hour',
	'total',
	'status',
	'is_verification',
	'have_alternative',
	'agree_for_alternative',
	'nurse_is_refuse_booking',
	'reason_of_refuse_booking',
	'one_time_or_regular',
	'start_date',
	'finish_date',
	'weeks',
	'days',
	'additional_email',
	'comment',
	'created_at',
	'updated_at',
	'client_fullname',
	'client_phone',
    ];

    public function time() {
        return $this->hasMany('App\Models\BookingTime', 'booking_id', 'id');
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

    public function payment(){
        return $this->hasOne('App\Models\Payment', 'booking_id', 'id');
    }
}
