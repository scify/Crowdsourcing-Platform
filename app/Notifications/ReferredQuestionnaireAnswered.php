<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferredQuestionnaireAnswered extends Notification implements ShouldQueue
{
    use Queueable;

    private $questionnaire;
    private $badge;
    private $badgeVM;

    public function __construct($questionnaire, GamificationBadge $badge, GamificationBadgeVM $badgeVM)
    {
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
        $message = (new MailMessage)
            ->subject('ECAS | Thank you for your referral!')
            ->greeting('Hello!')
            ->line('Someone answered to a questionnaire you shared!<br>"' . $this->questionnaire->title . '".<br><br><h2 style="text-align: center;">Congratulations!</h2>');

        $message->line('<div style="text-align: center;"><br><b>' . $this->badge->getEmailBody() . '</b><br><br></div>');

        $badge = $this->badgeVM;
        $message->line((String) view('gamification.badge-single', compact('badge')));
        $message->line('<br><p style="text-align: center;"><b>Are you ready for the next challenge?</b><br>Visit your dashboard to see next actions and unlock new badges</p>');
        $message->action('Go to Dashboard', url('/my-dashboard'))
            ->line('Thank you for using our application!');
        return $message;
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
