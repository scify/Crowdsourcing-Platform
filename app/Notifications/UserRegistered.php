<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRegistered extends Notification {
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $message = (new MailMessage)
            ->subject('Crowdsourcing Platform | Welcome!')
            ->greeting(__('notifications.thanks_message'))
            ->line('<div style="text-align:center; height: 200px;"><img class="badgeImg" style="height: 200px; margin-bottom: 0;" src=' . asset('images/active_participation.png') . '></div>');

        $message->line('<br><h1 style="text-align: center; margin-bottom: 5px"><b>' . __('notifications.make_an_impact') . '</b></h1>');
        $message->line('<p style="text-align: center; margin-bottom: 5px"><b>' . __('notifications.visit_your_dashboard_contribute') . '</b></p>');
        $message->action(__('notifications.go_to_dashboard'), route('my-dashboard'));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
