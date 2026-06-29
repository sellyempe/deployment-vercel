<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordCustom extends BaseResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generate absolute URL using request host to ensure it is always clickable and matches port/domain dynamically
        $relativeUrl = route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false);

        $url = request()->schemeAndHttpHost() . $relativeUrl;

        return (new \App\Mail\ResetPasswordMail($url))
            ->to($notifiable->routeNotificationFor('mail'));
    }
}