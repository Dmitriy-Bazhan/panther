<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ClientPaymentHappenedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $user;
    protected $payment;
    protected $template;
    protected $pdf;

    public function __construct($user, $payment, $pdf)
    {
        $template = MailTemplate::where('name', 'Client Payment Happened')->first();

        if(!$template){
            $template = $this->makeTemplate();
        }

        $this->url = url('/dashboard/client/payments');
        $this->user = $user;
        $this->template = $template->content;
        $this->payment = $payment;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $filename = config('app.name') . '_' . __('invoice.invoice') . '_' . \Carbon\Carbon::now()->format('Y-m-d_H:s') . '.pdf';

        return $this->subject(__('mail-message.to_client_of') . ' ' . Config::get('app.name'))
            ->view('mail.client-payment-happened')->with([
                'url' => $this->url,
                'template' => $this->template,
                'user' => $this->user,
                'payment' => $this->payment,
            ])->attachData($this->pdf->output(), $filename);
    }

    private function makeTemplate() {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid architecto corporis cum
                    cupiditate dolore dolorem, enim eum expedita magni maiores mollitia pariatur quidem quos recusandae
                    temporibus totam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid
                    architecto corporis cum cupiditate dolore dolorem, enim eum expedita magni maiores mollitia
                    pariatur quidem quos recusandae temporibus totam?';

        $template = MailTemplate::create([
            'name' => 'Client Payment Happened',
            'content' => 'Client Payment Happened ' . $lorem
        ]);

        return $template;
    }
}
