<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailThatYouHaveNewMessagesMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $template;
    protected $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->template = '';
        $this->url = url('dashboard/'. $user->entity_type .'/messages');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
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
