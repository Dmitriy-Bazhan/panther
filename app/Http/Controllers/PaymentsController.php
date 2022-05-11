<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Laravel\Cashier\Cashier;

class PaymentsController extends Controller
{
    public function getStripeApiToken()
    {
        if (config()->has('stripeAPIToken')) {
            $stripeAPIToken = config('stripeAPIToken');
        } else {
            $stripeAPIToken = Config::get('app.stripe_api');
        }

        $intentToken = auth()->user()->createSetupIntent();

        return response()->json(['success' => true, 'stripeAPIToken' => $stripeAPIToken, 'intentToken' => $intentToken]);
    }

    public function storePaymentMethod(Request $request)
    {
        $user = $request->user();
        $paymentMethodID = $request->get('payment_method');

        if ($user->stripe_id == null) {
            $user->createAsStripeCustomer();
        }

        $user->addPaymentMethod($paymentMethodID);
        $user->updateDefaultPaymentMethod($paymentMethodID);

        return response()->json(null, 204);
    }

    public function removePaymentMethod(Request $request)
    {
        $user = $request->user();
        $paymentMethodID = $request->get('id');

        $paymentMethods = $user->paymentMethods();

        foreach ($paymentMethods as $method) {
            if ($method->id == $paymentMethodID) {
                $method->delete();
                break;
            }
        }

        return response()->json(null, 204);
    }

    public function getPaymentMethods(Request $request)
    {
        $user = $request->user();
        $methods = [];

        if ($user->hasPaymentMethod()) {
            foreach ($user->paymentMethods() as $method) {
                array_push($methods, [
                    'id' => $method->id,
                    'brand' => $method->card->brand,
                    'last_four' => $method->card->last4,
                    'exp_month' => $method->card->exp_month,
                    'exp_year' => $method->card->exp_year,
                ]);
            }
        }

        return response()->json($methods);
    }

    public function paymentPay()
    {
        $stripedId = auth()->user()->stripe_id;
        $payment = Payment::find(request()->post('payment_id'));
        $paymentMethodId = request()->post('payment_method_id');

        $cashier = Cashier::findBillable($stripedId);
        try{
            $cashier->charge($payment->sum * 100, $paymentMethodId);
        }catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        $payment->status = 'payed';
        $payment->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
