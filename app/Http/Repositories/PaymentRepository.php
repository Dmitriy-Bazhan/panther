<?php


namespace App\Http\Repositories;


use App\Mail\AdminPaymentHappenedMail;
use App\Mail\ClientPaymentHappenedMail;
use App\Mail\NursePaymentHappenedMail;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PDF;

class PaymentRepository
{
    private $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function search($id = null, $status = null)
    {
        $payments = $this->payment->newQuery();

        if (!is_null($id)) {
            $payments->where('id', $id);
        }

        if (request()->filled('client_id')) {
            $payments->where('client_user_id', request('client_id'));
        }

        if (!is_null($status)) {
            $payments->where('status', $status);
        }

        $payments->with([
            'booking.nurse',
            'booking.client',
        ]);

        return $payments->paginate(config('settings.listing_paginate'));
    }

    public function sendNotificationsAfterPay($payment = null)
    {
        if(is_null($payment)){
            //todo::log
            abort(409);
        }

        $admins = User::where('entity_type', 'admin')->get();

        foreach ($admins as $admin) {
            app()->setLocale(User::find($admin->id)->prefs->pref_lang);
            if (config('settings.mail_use_queue')) {
                Mail::mailer('smtp')->to($admin->email)
                    ->queue(new AdminPaymentHappenedMail($admin, $payment));
            } else {
                Mail::mailer('smtp')->to($admin->email)
                    ->send(new AdminPaymentHappenedMail($admin, $payment));
            }
        }

        app()->setLocale(User::find($payment->booking->nurse->id)->prefs->pref_lang);
        if (config('settings.mail_use_queue')) {
            Mail::mailer('smtp')->to($payment->booking->nurse->email)
                ->queue(new NursePaymentHappenedMail($payment->booking->nurse, $payment));
        } else {
            Mail::mailer('smtp')->to($payment->booking->nurse->email)
                ->send(new NursePaymentHappenedMail($payment->booking->nurse, $payment));
        }

        app()->setLocale(User::find($payment->booking->client->id)->prefs->pref_lang);
        $pdf = $this->makePdfInvoiceToClient($payment);

        if (config('settings.mail_use_queue')) {
            Mail::mailer('smtp')->to($payment->booking->client->email)
                ->queue(new ClientPaymentHappenedMail($payment->booking->client, $payment, $pdf));
        } else {
            Mail::mailer('smtp')->to($payment->booking->client->email)
                ->send(new ClientPaymentHappenedMail($payment->booking->client, $payment, $pdf));
        }

        return;
    }

    public function makePdfInvoiceToClient($payment)
    {
        $data = [
            'payment' => $payment,
        ];

        return PDF::loadView('pdf.invoice-to-client', $data);
    }
}
