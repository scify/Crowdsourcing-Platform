<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireResponded extends BadgeActionOccured implements ShouldQueue
{
    use Queueable;


    public function __construct($questionnaire, GamificationBadge $badge, GamificationBadgeVM $badgeVM) {
        parent::__construct($badgeVM,
            'Thank you for your contribution!',
            'Hello!',
            'Thank you for responding to our questionnaire with title "' . $questionnaire->title . '". It means a lot!',
            $badge->getEmailBody(),
        'Increase your impact',
        'Visit your dashboard to invite your friends'
        );
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return parent::toMail($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
