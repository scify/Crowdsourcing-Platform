<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\CrowdSourcingProject\CrowdSourcingProjectTranslation;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireResponded extends BadgeActionOccured implements ShouldQueue {
    use Queueable;

    protected $crowdSourcingProjectTranslation;

    public function __construct(QuestionnaireFieldsTranslation  $questionnaireFieldsTranslation,
                                GamificationBadge               $badge,
                                GamificationBadgeVM             $badgeVM,
                                CrowdSourcingProjectTranslation $crowdSourcingProjectTranslation) {
        $this->questionnaireFieldsTranslation = $questionnaireFieldsTranslation;
        $this->badge = $badge;
        $this->badgeVM = $badgeVM;
        $this->crowdSourcingProjectTranslation = $crowdSourcingProjectTranslation;
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
            __("notifications.thank_you_for_contribution"),
            __("notifications.hello"),
            __("notifications.thanks_message_for_answering_2") . " <b>" . $this->questionnaireFieldsTranslation->title . "</b> " .  __("notifications.really_means")
            . '<br><br><div id="intro_text">' . $this->crowdSourcingProjectTranslation->questionnaire_response_email_intro_text . '</div>',
            $this->badge->getEmailBody(),
            '<br><div id="outro_text">' . $this->crowdSourcingProjectTranslation->questionnaire_response_email_outro_text . '</div>',
            __("notifications.increase_your_impact") . "<br>",
            __("notifications.invite_your_friends"),
             __("notifications.thanks_message_2") . "<br><br>The Crowdsourcing Team");
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
