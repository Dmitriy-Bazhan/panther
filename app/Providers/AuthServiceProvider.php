<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

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
                return (new MailMessage)
                    ->subject('Verify Email Address')
                    ->line(__('mail-message.email_verification_for_nurses'))
                    ->action('Verify Email Address', $url);
            }

            if (auth()->user()->is_client) {
                return (new MailMessage)
                    ->subject('Verify Email Address')
                    ->line(__('mail-message.email_verification_for_clents'))
                    ->action('Verify Email Address', $url);
            }
        });
    }
}
