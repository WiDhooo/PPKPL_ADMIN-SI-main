<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \\Illuminate\\Notifications\\Messages\\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Kata Sandi Anda')
            ->view('emails.custom_reset_password', [
                'url' => url(config('app.url').route('password.reset', $this->token, false)),
                'user' => $notifiable,
            ]);
    }
}
