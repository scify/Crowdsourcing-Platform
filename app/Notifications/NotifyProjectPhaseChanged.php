<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyProjectPhaseChanged extends Notification implements ShouldQueue {
    use Queueable;

    protected $projectName;
    protected $locale;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $projectName, string $locale) {
        $this->projectName = $projectName;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject(__('notifications.project_phase_changed_subject', ['project' => $this->projectName], $this->locale))
            ->greeting(__('notifications.hello', [], $this->locale) . ' ' . ($notifiable->nickname ?? $notifiable->name ?? ''))
            ->line(__('notifications.project_phase_changed_body', ['project' => $this->projectName], $this->locale));
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
