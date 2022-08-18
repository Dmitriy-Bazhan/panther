<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserThatYouHaveNewMessagesMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $template;
    protected $url;

    public function __construct($user)
    {
        $this->template = MailTemplate::where('name', 'Mail That You Have New Messages')->first()->content;
        $this->user = $user;
        $this->url = url('dashboard/'. $user->entity_type .'/messages');
    }

    public function build()
    {
        return $this->subject(__('mail-message.sent_new_booking_to_nurse_title'))
            ->view('mail.mail_that_you_have_new_messages')->with([
                'user' => $this->user,
                'template' => $this->template,
                'url' => $this->url,
            ]);
    }
}
