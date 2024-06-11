<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireResponded extends BadgeActionOccured implements ShouldQueue {
    use Queueable;

    protected $title;
    protected $questionnaire_response_email_outro_text;
    protected $questionnaire_response_email_intro_text;

    public function __construct($questionnaireFieldsTranslation,
        GamificationBadge $badge,
        GamificationBadgeVM $badgeVM,
        $crowdSourcingProjectTranslation,
        string $locale) {
        $this->title = $questionnaireFieldsTranslation->title;
        $this->questionnaire_response_email_intro_text = $crowdSourcingProjectTranslation->questionnaire_response_email_intro_text;
        $this->questionnaire_response_email_outro_text = $crowdSourcingProjectTranslation->questionnaire_response_email_outro_text;
        $this->badge = $badge;
        $this->badgeVM = $badgeVM;
        $this->locale = $locale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return parent::objectToMail(
            $this->badgeVM,
            __('notifications.thank_you_for_contribution', [], $this->locale),
            __('notifications.hello', [], $this->locale),
            __('notifications.thanks_message_for_answering_2', [], $this->locale) . ' <b>' . $this->title . '</b> ' . __('notifications.really_means', [], $this->locale)
            . '<br><br><div id="intro_text">' . $this->questionnaire_response_email_intro_text . '</div>',
            $this->badge->getEmailBody(),
            '<br><div id="outro_text">' . $this->questionnaire_response_email_outro_text . '</div>',
            __('notifications.increase_your_impact', [], $this->locale) . '<br>',
            __('notifications.invite_your_friends', [], $this->locale),
            __('notifications.thanks_message_2', [], $this->locale) . '<br><br>The Crowdsourcing Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
