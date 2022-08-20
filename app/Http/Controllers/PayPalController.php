<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PaymentRepository;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public $payment_repo;

    public function __construct(PaymentRepository $payment_repo)
    {
        parent::__construct();
        $this->payment_repo = $payment_repo;
    }

    public function createTransaction()
    {
        return redirect()->to('dashboard/client/payments');
    }

    //make transaction
    public function processTransaction(Request $request)
    {
        session()->put('payment_id', $request->get('payment_id'));
        $payment = Payment::find($request->get('payment_id'));

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $payment->sum
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('createTransaction')
                ->with('error', 'Something went wrong.');

        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        $payment_id = session()->get('payment_id');
        $payments = $this->payment_repo->search($payment_id);
        $payment = $payments->first();

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            Booking::where('id', $payment->booking_id)->update([
                'status' => 'in_process',
            ]);

            $payment->status = 'payed';
            $payment->method = 'Paypal';
            $payment->save();

            $this->payment_repo->sendNotificationsAfterPay($payment);

            return redirect()
                ->route('createTransaction')
                ->with('success', 'Transaction complete.');
        } else {
            Log::channel('app_logs')->error('PayPalController@successTransaction payment did not pass');
            //payment did not pass
            $payment->status = 'break';
            $payment->method = 'Stripe';
            $payment->save();

            //todo:sendNotificationsPaymentDidNotPass
            //$this->payment_repo->sendNotificationsPaymentDidNotPass($payment);
//            return back()->with('error', $exception->getMessage());
            return response()->json([
                'success' => false, 'error' => 'payment did not pass'
            ]);

            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('createTransaction')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
