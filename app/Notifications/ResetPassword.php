<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification {
    public function __construct(public $token) {}

    public function via($notifiable): array {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject(__('email_messages.reset_password'))
            ->line(__('email_messages.email_reset_password'))
            // Built from APP_URL, never from the request Host header, so the token cannot be sent to another host.
            ->action(__('email_messages.reset_password'), rtrim((string) config('app.url'), '/') . '/' . app()->getLocale() . '/password/reset/' . $this->token)
            ->line(__('email_messages.no_further_action'));
    }
}
