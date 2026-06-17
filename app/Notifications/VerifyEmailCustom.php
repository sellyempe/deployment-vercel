<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class VerifyEmailCustom extends BaseVerifyEmail
{
    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Verifikasi Alamat Email - Pink Tour and Travel'))
            ->greeting(Lang::get('Halo!'))
            ->line(Lang::get('Terima kasih telah mendaftar di Pink Tour and Travel. Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda dan mengaktifkan akun Anda.'))
            ->action(Lang::get('Verifikasi Email'), $url)
            ->line(Lang::get('Jika Anda tidak merasa mendaftar di layanan kami, abaikan saja email ini.'))
            ->salutation(Lang::get('Salam Hangat,') . "\n" . 'Pink Tour and Travel');
    }
}
