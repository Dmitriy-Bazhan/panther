<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWarningToUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $customMessage;

    public function __construct($user, $customMessage)
    {
        $this->user = $user;
        $this->customMessage = $customMessage;
    }

    public function build()
    {
        return $this->subject(__('mail-message.email_warning'))
            ->view('mail.user-warning')->with([
                'url' => url('/'),
                'user' => $this->user,
                'customMessage' => $this->customMessage,
            ]);
    }
}
