<?php

namespace App\Notifications;

use App\Models\Solution\Solution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SolutionPublished extends Notification implements ShouldQueue {
    use Queueable;

    protected Solution $solution;

    /**
     * Create a new notification instance.
     */
    public function __construct(Solution $solution) {
        $this->solution = $solution;
    }

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
            ->subject('Crowdsourcing Platform | ' . __('notifications.solution_published') . ': ' . $this->solution->defaultTranslation->title)
            ->line(__('notifications.solution_published_intro'))
            ->line('<div style="text-align:center; height: 200px; margin-bottom: 10px;"><img style="height: 200px; margin-bottom: 0;" src=' . asset('images/dancing.png') . '></div>')
            ->line('<div style="text-align:center; font-size: 10px; margin-bottom: 10px;"><a href="https://www.flaticon.com/free-stickers/people" title="people stickers">People stickers created by Stickers - Flaticon</a></div>')
            ->greeting(__('notifications.hello') . ' ' . $notifiable->nickname . '!')
            ->line(__('notifications.solution_published_message'))
            ->action(__('notifications.see_the_solution'), route('problem.show.solutions', ['problem_slug' => $this->solution->problem->slug, 'project_slug' => $this->solution->problem->project->slug]) . '?solution_id=' . $this->solution->id)
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
