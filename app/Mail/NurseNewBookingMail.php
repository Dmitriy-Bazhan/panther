<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NurseNewBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $nurse;
    protected $client;
    protected $url;
    protected $template;

    public function __construct($nurse, $client)
    {
        $this->template = MailTemplate::where('name', 'Send Nurse When New Booking')->first()->content;
        $this->nurse = $nurse;
        $this->client = $client;
        $this->url = url('/dashboard/nurse/bookings');
    }

    public function build()
    {

        return $this->subject(__('mail-message.sent_new_booking_to_nurse_title'))
            ->view('mail.send-nurse-new-booking-mail')->with([
                'client' => $this->client,
                'user' => $this->nurse,
                'url' => $this->url,
                'template' => $this->template,
            ]);
    }
}
