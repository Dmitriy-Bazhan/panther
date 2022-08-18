<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class AdminPaymentHappenedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $user;
    protected $payment;
    protected $template;

    public function __construct($user, $payment)
    {
        $template = MailTemplate::where('name', 'Admin Payment Happened')->first();

        if(!$template){
            $template = $this->makeTemplate();
        }

        $this->url = url('/dashboard/admin/payments');
        $this->user = $user;
        $this->template = $template->content;
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject(__('mail-message.to_admin_of') . ' ' . Config::get('app.name'))
            ->view('mail.admin-payment-happened')->with([
                'url' => $this->url,
                'template' => $this->template,
                'user' => $this->user,
                'payment' => $this->payment,
            ]);
    }

    private function makeTemplate() {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid architecto corporis cum
                    cupiditate dolore dolorem, enim eum expedita magni maiores mollitia pariatur quidem quos recusandae
                    temporibus totam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid
                    architecto corporis cum cupiditate dolore dolorem, enim eum expedita magni maiores mollitia
                    pariatur quidem quos recusandae temporibus totam?';

        $template = MailTemplate::create([
            'name' => 'Admin Payment Happened',
            'content' => 'Admin Payment Happened ' . $lorem
        ]);

        return $template;
    }
}
