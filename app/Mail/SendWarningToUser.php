<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWarningToUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $customMessage;
    protected $template;

    public function __construct($user, $customMessage)
    {
        $reflection = new \ReflectionClass($this);
        $this->template = MailTemplate::where('name', $reflection->getShortName() )->first()->content;
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
                'template' => $this->template,
            ]);
    }
}
