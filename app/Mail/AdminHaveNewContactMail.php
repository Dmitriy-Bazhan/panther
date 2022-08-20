<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminHaveNewContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $contact;
    protected $url;
    protected $template;

    public function __construct($user, $contact)
    {
        $template = MailTemplate::where('name', 'Admin Have New Contact')->first();

        if(!$template){
            $template = $this->makeTemplate();
        }

        $this->template = $template->content;
        $this->user = $user;
        $this->contact = $contact;
        $this->url = url('/dashboard/admin/contacts');
    }

    public function build()
    {
        return $this->subject(__('mail-message.have_new_contact'))
            ->view('mail.admin-have-new-contact')->with([
                'user' => $this->user,
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
            'name' => 'Admin Have New Contact',
            'content' => 'Admin Have New Contact ' . $lorem
        ]);

        return $template;
    }
}
