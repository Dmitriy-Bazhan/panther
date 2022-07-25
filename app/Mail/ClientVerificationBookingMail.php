<?php

namespace App\Mail;

use App\Models\MailTemplate;
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
    protected $template;

    public function __construct($booking,$nurse, $client)
    {
        $reflection = new \ReflectionClass($this);
        $this->template = MailTemplate::where('name', $reflection->getShortName() )->first()->content;
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
                'template' => $this->template,
                'booking' => $this->booking,
                'nurse' => $this->nurse,
                'user' => $this->client,
                'url' => $this->url
            ]);
    }
}
