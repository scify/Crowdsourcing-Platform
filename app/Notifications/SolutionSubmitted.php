<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Solution\Solution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolutionSubmitted extends Notification implements ShouldQueue {
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Solution $solution) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage {
        return (new MailMessage)
            ->subject('Crowdsourcing Platform | ' . __('notifications.solution_submitted') . ': ' . $this->solution->defaultTranslation->title)
            ->line(__('notifications.thank_you_for_contribution'))
            ->line('<div style="text-align:center; height: 200px; margin-bottom: 10px;"><img style="height: 200px; margin-bottom: 0;" src=' . asset('images/team-spirit.png') . '></div>')
            ->line('<div style="text-align:center; font-size: 10px; margin-bottom: 10px;"><a href="https://www.flaticon.com/free-stickers/people" title="people stickers">People stickers created by Stickers - Flaticon</a></div>')
            ->greeting(__('notifications.hello') . ' ' . $notifiable->nickname . '!')
            ->line(__('notifications.thanks_for_proposing_solution'))
            ->action(__('notifications.visit_your_dashboard'), route('my-dashboard', ['locale' => app()->getLocale()]))
            ->line(__('notifications.making_impact'))
            ->salutation(__('notifications.thanks_message_2'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array {
        return [
            //
        ];
    }
}
