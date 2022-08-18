<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentApiSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        //stripe
        'stripe_key',
        'stripe_secret',
        'stripe_currency',

        //paypal
        'paypal_mode',
        'paypal_sandbox_client_id',
        'paypal_sandbox_client_secret',
        'paypal_sandbox_app_id',
        'paypal_live_client_id',
        'paypal_live_client_secret',
        'paypal_live_app_id',

        'paypal_payment_action',
        'paypal_currency',
        'paypal_notify_url',
        'paypal_locale',
        'paypal_validate_ssl',
    ];

    public static function __set_state($an_array)
    {
        // TODO: Implement __set_state() method.
    }
}
