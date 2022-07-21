<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $text;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $text, $user)
    {
        $this->url = $url;
        $this->text = $text;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('mail-message.email_verification'))
            ->view('mail.verification-mail')->with([
            'url' => $this->url,
            'text' => $this->text,
            'user' => $this->user,
        ]);
    }
}
