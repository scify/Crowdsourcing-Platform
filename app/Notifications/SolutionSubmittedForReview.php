<?php

namespace App\Notifications;

use App\Models\Solution\Solution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolutionSubmittedForReview extends Notification implements ShouldQueue {
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
            ->subject('Crowdsourcing Platform | ' . __('notifications.solution_submitted_for_review') . ': ' . $this->solution->defaultTranslation->title)
            ->line(__('notifications.new_solution_submitted'))
            ->line('<div style="text-align:center; height: 200px; margin-bottom: 20px;"><img class="badgeImg" style="height: 200px; margin-bottom: 0;" src=' . asset('images/active_participation.webp') . '></div>')
            ->greeting(__('notifications.hello') . ' ' . $notifiable->nickname . '!')
            ->line(__('notifications.a_user_has_proposed_solution'))
            ->line('Username: ' . $this->solution->creator?->nickname ?? __('notifications.anonymous'))
            ->line('Email: ' . $this->solution->creator?->email ?? __('notifications.anonymous'))
            ->line('Campaign: ' . $this->solution->problem->project->defaultTranslation->name)
            ->line('Problem: ' . $this->solution->problem->defaultTranslation->title)
            ->line('Solution: ' . $this->solution->defaultTranslation->title)
            ->line(__('notifications.check_solution_and_review'))
            ->action(__('notifications.see_submitted_solutions'), route('solutions.index', ['locale' => app()->getLocale()]))
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
