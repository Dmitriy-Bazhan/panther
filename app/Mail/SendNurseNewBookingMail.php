<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNurseNewBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $nurse;
    protected $client;
    protected $url;

    public function __construct($nurse, $client)
    {
        $this->nurse = $nurse;
        $this->client = $client;
        $this->url = url('/dashboard/nurse/bookings');
    }

    public function build()
    {

        return $this->subject(__('mail-message.sent_new_booking_to_nurse_title'))
            ->view('mail.send-nurse-new-booking-mail')->with([
            'client' => $this->client,
            'nurse' => $this->nurse,
            'url' => $this->url,
        ]);
    }
}
