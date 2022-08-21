<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminAnswerByContact extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;
    protected $answer;
    protected $url;
    protected $template;

    public function __construct($contact, $answer)
    {
        $template = MailTemplate::where('name', 'Admin Answer By Contact')->first();

        if(!$template){
            $template = $this->makeTemplate();
        }

        $this->template = $template->content;
        $this->answer = $answer;
        $this->contact = $contact;
        $this->url = url('/');
    }

    public function build()
    {
        return $this->subject(config('app.name'))
            ->view('mail.admin-answer-by-contact')->with([
                'answer' => $this->answer,
                'contact' => $this->contact,
                'url' => $this->url,
                'template' => $this->template,
            ]);
    }

    private function makeTemplate() {
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid architecto corporis cum
                    cupiditate dolore dolorem, enim eum expedita magni maiores mollitia pariatur quidem quos recusandae
                    temporibus totam? Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab ad aliquid
                    architecto corporis cum cupiditate dolore dolorem, enim eum expedita magni maiores mollitia
                    pariatur quidem quos recusandae temporibus totam?';

        $template = MailTemplate::create([
            'name' => 'Admin Answer By Contact',
            'content' => 'Admin Answer By Contact ' . $lorem
        ]);

        return $template;
    }
}
