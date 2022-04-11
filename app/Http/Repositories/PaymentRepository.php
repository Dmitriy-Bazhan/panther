<?php


namespace App\Http\Repositories;


use App\Models\Payment;

class PaymentRepository
{
    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function search($id = null, $status = null) {
        $payments = $this->payment->newQuery();

        if(!is_null($id)){
            $payments->where('id', $id);
        }

        if(request()->filled('client_id')){
            $payments->where('client_user_id', request('client_id'));
        }

        if(!is_null($status)){
            $payments->where('status', $status);
        }

        $payments->with([
            'booking.nurse',
            'booking.client',
        ]);

        return $payments->paginate(1);
    }
}
