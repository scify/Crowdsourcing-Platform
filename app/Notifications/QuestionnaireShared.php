<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireShared extends BadgeActionOccured implements ShouldQueue
{
    use Queueable;


    public function __construct($questionnaire, GamificationBadge $badge, GamificationBadgeVM $badgeVM) {
        parent::__construct($badgeVM,
            'Thank you for sharing!',
            'Hello!',
            'Thank for sharing questionnaire "' . $questionnaire->title . '"!',
            $badge->getEmailBody(),
        'Sharing is caring!',
        'Visit your dashboard to see what to do next'
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
