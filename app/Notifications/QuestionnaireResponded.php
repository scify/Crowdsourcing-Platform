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
            'Thank you for taking the time to answer our questionnaire: "' . $this->questionnaire->title . '". This really means a lot to us!'
            .'<br><br>Thanks to your contribution we are one step closer to understanding the type of obstacles EU citizens encounter when moving within the EU and engaging in political life. ',
            $this->badge->getEmailBody(),
            'If you have any further questions, or would like more information about ECAS\' work in the field of EU Rights and Digital Democracy do not hesitate to <span style="text-decoration: underline">get in touch</span> with us or subscribe to our newsletter via our <a href="https://ecas.org/" target="_blank">website!</a>',
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
