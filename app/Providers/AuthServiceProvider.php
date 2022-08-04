<?php

namespace App\Providers;

use App\Mail\VerificationMail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {

            $user = auth()->user();
            if (config('mail.mail_use_queue')) {
                Mail::mailer('smtp')->to(auth()->user()->email)->
                queue(new VerificationMail($url, $user));
            } else {
                Mail::mailer('smtp')->to(auth()->user()->email)->
                send(new VerificationMail($url, $user));
            }
            return new VerificationMail($url, $user);
        });
    }
}
