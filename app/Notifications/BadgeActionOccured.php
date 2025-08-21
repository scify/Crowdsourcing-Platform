<?php

declare(strict_types=1);

namespace App\Notifications;

use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BadgeActionOccured extends Notification implements ShouldQueue {
    use Queueable;

    protected $questionnaire;

    protected $questionnaireFieldsTranslation;

    protected $badge;

    protected $badgeVM;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array {
        return ['mail'];
    }

    public function objectToMail(GamificationBadgeVM $badge,
        string $subject,
        $greeting,
        $title,
        string $beforeBadge,
        string $afterBadge,
        string $actionText,
        string $actionText2,
        $salutation = null
    ) {
        $message = (new MailMessage)
            ->subject('Crowdsourcing Platform | ' . $subject)
            ->greeting($greeting)
            ->line($title);

        $badge->color = 'transparent';

        $message->line('<div style="text-align: center;"><br><b>' . $beforeBadge . '</b><br><br></div>');
        $message->line((string) view('gamification.badge-single', ['badge' => $badge]));
        $message->line('<br>' . $afterBadge);
        $message->line('<br><p style="text-align: center"><b>' . $actionText . '</b><br>' . $actionText2 . '</p>');
        if ($salutation) {
            $message->salutation($salutation);
        }

        $message->action(__('notifications.go_to_dashboard', [], $this->locale), route('my-dashboard', ['locale' => $this->locale]));

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toArray($notifiable): array {
        return [
            //
        ];
    }
}
