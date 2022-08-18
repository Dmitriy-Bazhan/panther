<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $template;
    protected $user;

    public function __construct($url, $user)
    {
        $this->template = MailTemplate::where('name', 'Verification Mail')->first()->content;
        $this->url = $url;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject(__('mail-message.email_verification'))
            ->view('mail.verification-mail')->with([
                'url' => $this->url,
                'user' => $this->user,
                'template' => $this->template,
            ]);
    }
}
