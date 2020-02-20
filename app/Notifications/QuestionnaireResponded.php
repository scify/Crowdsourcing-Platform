<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\Questionnaire;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class QuestionnaireResponded extends BadgeActionOccured implements ShouldQueue
{
    use Queueable;

    public function __construct(Questionnaire $questionnaire, GamificationBadge $badge, GamificationBadgeVM $badgeVM) {
        $this->questionnaire = $questionnaire;
        $this->badge = $badge;
        $this->badgeVM = $badgeVM;
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
        return parent::objectToMail(
            $this->badgeVM,
            'Thank you for your contribution!',
            'Hello!',
            'Thank you for taking the time to answer our questionnaire: "<b>' . $this->questionnaire->title . '</b>". This really means a lot to us!'
            .'<br><br>' . $this->questionnaire->project->communication->questionnaire_response_email_intro_text,
            $this->badge->getEmailBody(),
            $this->questionnaire->project->communication->questionnaire_response_email_outro_text,
            'Increase your impact<br>',
            'Go to your dashboard, and invite your friends!',
            'Thank you once again!<br><br>The Crowdsourcing Team');
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
