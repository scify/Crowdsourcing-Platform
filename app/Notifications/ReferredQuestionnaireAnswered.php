<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferredQuestionnaireAnswered extends BadgeActionOccured implements ShouldQueue {
    use Queueable;

    public function __construct(QuestionnaireFieldsTranslation $questionnaireFieldsTranslation,
                                GamificationBadge $badge, GamificationBadgeVM $badgeVM) {
        $this->title = $questionnaireFieldsTranslation->title;
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
            __("notifications.thank_you_for_referral"),
            __("notifications.making_impact"),
            __("notifications.someone_answered_to_questionnaire") . "<b>" . $this->title . "</b><br>",
            $this->badge->getEmailBody(),
            '',
            __("notifications.increase_your_impact"),
            __("notifications.visit_your_dashboard_and_invite"));
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
