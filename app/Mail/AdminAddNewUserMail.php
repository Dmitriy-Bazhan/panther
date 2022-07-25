<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class AdminAddNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $user;
    protected $password;
    protected $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $reflection = new \ReflectionClass($this);
        $this->url = url('/login');
        $this->user = $user;
        $this->template = MailTemplate::where('name', $reflection->getShortName() )->first()->content;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('mail-message.you_have_been_added_to_the_site') . ' ' . Config::get('app.name'))
            ->view('mail.admin-add-new-user')->with([
                'url' => $this->url,
                'template' => $this->template,
                'user' => $this->user,
                'password' => $this->password,
            ]);
    }
}
