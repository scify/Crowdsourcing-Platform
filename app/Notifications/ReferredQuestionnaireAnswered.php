<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferredQuestionnaireAnswered extends BadgeActionOccured implements ShouldQueue {
    use Queueable;

    public function __construct(QuestionnaireFieldsTranslation $questionnaireFieldsTranslation, GamificationBadge $badge, GamificationBadgeVM $badgeVM) {
        $this->questionnaireFieldsTranslation = $questionnaireFieldsTranslation;
        $this->badge = $badge;
        $this->badgeVM = $badgeVM;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return parent::objectToMail(
            $this->badgeVM,
            'Thank you for your referral!',
            'You are making an impact!',
            'Someone answered to a questionnaire you shared!<br>"<b>' . $this->questionnaireFieldsTranslation->title . '</b>".<br>',
            $this->badge->getEmailBody(),
            '',
            'Increase your impact',
            'Visit your dashboard and invite more friends');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
