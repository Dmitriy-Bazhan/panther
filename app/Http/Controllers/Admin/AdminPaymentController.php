<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PaymentRepository;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public $payment_repo;

    public function __construct(PaymentRepository $payment_repo)
    {
        parent::__construct();
        $this->payment_repo = $payment_repo;
    }

    public function index(){
        $status = request('status');
        $id = request()->filled('id') && is_numeric(request('id')) ? request('id') : null;

        if($status){
            $payments = PaymentResource::collection($this->payment_repo->search($id, $status))->response()->getData();
        }else{
            $payments = PaymentResource::collection($this->payment_repo->search($id))->response()->getData();
        }

        $payments_wait_sum = Payment::where('status', 'wait')->sum('sum');
        $payments_payed_sum = Payment::where('status', 'payed')->sum('sum');

        return response()->json([
            'success' => true,
            'payments' => $payments,
            'payments_wait_sum' => $payments_wait_sum,
            'payments_payed_sum' => $payments_payed_sum,
        ]);
    }

    public function show($id){
        $payments = $this->payment_repo->search($id);
        $payment = $payments->first();

        return response()->json(['success' => true, 'payment' => $payment]);
    }
}
