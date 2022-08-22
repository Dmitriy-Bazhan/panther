<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Repositories\PaymentRepository;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class ClientPaymentsController extends Controller
{
    protected $paymentRepo;

    public function __construct(PaymentRepository $paymentRepo)
    {
        parent::__construct();
        $this->paymentRepo = $paymentRepo;
    }

    public function index()
    {
        if(!request()->filled('client_id') && !is_numeric(request('client_id'))){
            //todo:hmm
            abort(409);
        }

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

//        $waitingPayments = PaymentResource::collection($this->paymentRepo->search(null, 'wait'))->response()->getData();
//        $payedPayments = PaymentResource::collection($this->paymentRepo->search(null, 'payed'))->response()->getData();
//        $refusePayments = PaymentResource::collection($this->paymentRepo->search(null, 'refuse'))->response()->getData();
//        $breakPayments = PaymentResource::collection($this->paymentRepo->search(null, 'break'))->response()->getData();
//
//
//        return response()->json([
//            'success' => true,
//            'waitingPayments' => $waitingPayments,
//            'payedPayments' => $payedPayments,
//            'refusePayments' => $refusePayments,
//            'breakPayments' => $breakPayments,
//        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!is_numeric($id)){
            abort(409);
        }

        Payment::where('id', $id)->update([

        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
