<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientVerificationBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $booking;
    protected $nurse;
    protected $client;
    protected $url;

    public function __construct($booking,$nurse, $client)
    {
        $this->booking = $booking;
        $this->nurse = $nurse;
        $this->client = $client;
        $this->url = url('/booking/verification/' . $booking->id . '/' . $client->id);
    }

    public function build()
    {

        return $this->subject(__('mail-message.client_booking_verification'))
            ->view('mail.client-verification-booking')
            ->with([
                'booking' => $this->booking,
                'nurse' => $this->nurse,
                'client' => $this->client,
                'url' => $this->url
            ]);
    }
}
