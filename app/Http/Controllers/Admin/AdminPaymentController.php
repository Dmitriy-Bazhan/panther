<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PaymentRepository;
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
        $payments = $this->payment_repo->search();

        return response()->json(['success' => true, 'payments' => $payments]);
    }

    public function show($id){
        $payments = $this->payment_repo->search($id);
        $payment = $payments->first();

        return response()->json(['success' => true, 'payment' => $payment]);
    }
}
