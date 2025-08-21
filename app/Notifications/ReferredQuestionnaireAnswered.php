<?php

declare(strict_types=1);

namespace App\Notifications;

use App\BusinessLogicLayer\Gamification\GamificationBadge;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferredQuestionnaireAnswered extends BadgeActionOccured implements ShouldQueue {
    public $title;

    use Queueable;

    public function __construct(QuestionnaireFieldsTranslation $questionnaireFieldsTranslation,
        GamificationBadge $badge,
        GamificationBadgeVM $badgeVM,
        string $locale) {
        $this->title = $questionnaireFieldsTranslation->title;
        $this->badge = $badge;
        $this->badgeVM = $badgeVM;
        $this->locale = $locale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     */
    public function via($notifiable): array {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return parent::objectToMail(
            $this->badgeVM,
            __('notifications.thank_you_for_referral', [], $this->locale),
            __('notifications.making_impact', [], $this->locale),
            __('notifications.someone_answered_to_questionnaire', [], $this->locale) . '<b>' . $this->title . '</b><br>',
            $this->badge->getEmailBody(),
            '',
            __('notifications.increase_your_impact', [], $this->locale),
            __('notifications.visit_your_dashboard_and_invite', [], $this->locale),
            $this->locale);
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
