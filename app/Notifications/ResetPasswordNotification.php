<?php


namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get(__('passwords.email.subject')))
            ->line(Lang::get(__('passwords.email.text')))
            ->action(Lang::get(__('passwords.email.title')), url(config('app.url') . '/reset-password/' . $this->token) . '?email=' . urlencode($notifiable->email))
            ->line(Lang::get(__('passwords.email.expire_text'), ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get(__('passwords.email.text_warning')));
    }
}
