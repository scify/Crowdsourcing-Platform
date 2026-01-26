<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Notifications\Contracts\CampaignNotificationInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyProjectEnded extends Notification implements CampaignNotificationInterface, ShouldQueue {
    use Queueable;

    public $locale;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected string $projectName, string $locale) {
        $this->locale = $locale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $params = [
            'project' => $this->projectName,
            'date' => now()->format('d.m.Y'),
        ];

        return (new MailMessage)
            ->subject(__('notifications.project_ended_subject', $params, $this->locale))
            ->greeting(__('notifications.project_ended_greeting', $params, $this->locale))
            ->line(__('notifications.project_ended_body', $params, $this->locale))
            ->line('<br/>')
            ->salutation(__('notifications.project_ended_salutation', $params, $this->locale));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array {
        return [
            'project' => $this->projectName,
        ];
    }
}
