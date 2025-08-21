<?php

declare(strict_types=1);

namespace App\Notifications;

use App\BusinessLogicLayer\Gamification\GamificationBadge;
use App\Models\Questionnaire\QuestionnaireFieldsTranslation;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireShared extends BadgeActionOccured implements ShouldQueue {
    use Queueable;

    protected $title;

    protected $badge;

    protected $badgeVM;

    /**
     * @param  string  $locale  We add the locale here because this notification may be trigger by an api.web action.
     */
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
            __('notifications.thank_you_for_sharing', [], $this->locale),
            __('notifications.hello', [], $this->locale),
            __('notifications.sharing_the_questionnaire', [], $this->locale) . '<b>' . $this->title . '</b>!',
            $this->badge->getEmailBody(),
            '',
            __('notifications.sharing_is_caring', [], $this->locale),
            __('notifications.visit_your_dashboard', [], $this->locale));
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
