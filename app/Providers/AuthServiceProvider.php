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

            if (auth()->user()->is_nurse) {

                $text = __('mail-message.email_verification_for_nurses');
                $user = auth()->user();

                if (config('mail_use_queue')) {
                    Mail::mailer('smtp')->to(auth()->user()->email)->
                    queue(new VerificationMail($url, $text, $user));
                } else {
                    Mail::mailer('smtp')->to(auth()->user()->email)->
                    send(new VerificationMail($url, $text, $user));
                }

                return new VerificationMail($url, $text, $user);
            }

            if (auth()->user()->is_client) {

                $text = __('mail-message.email_verification_for_clents');
                $user = auth()->user();

                if (config('mail_use_queue')) {
                    Mail::mailer('smtp')->to(auth()->user()->email)->
                    queue(new VerificationMail($url, $text, $user));
                } else {
                    Mail::mailer('smtp')->to(auth()->user()->email)->
                    send(new VerificationMail($url, $text, $user));
                }

                return new VerificationMail($url, $text, $user);
            }
        });
    }
}
