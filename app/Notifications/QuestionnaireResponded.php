<?php

namespace App\Notifications;

use App\BusinessLogicLayer\gamification\GamificationBadge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuestionnaireResponded extends Notification implements ShouldQueue
{
    use Queueable;

    private $questionnaire;
    private $badge;

    /**
     * Create a new notification instance.
     *
     * @param $questionnaire
     * @param GamificationBadge $badge
     */
    public function __construct($questionnaire, GamificationBadge $badge)
    {
        $this->questionnaire = $questionnaire;
        $this->badge = $badge;
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
            ->subject('ECAS | Thank you for your contribution!')
            ->greeting('Hello!')
            ->line('Thank you for responding to our questionnaire with title "' . $this->questionnaire->title . '". It means a lot!');
        if ($this->badge) {
            $message
                ->line($this->badge->getEmailBody());
        }
        $message->line('<p style="text-align: center"><b>Are you ready for the next badge?</b>
                            <br>Visit your dashboard to see next actions and unlock new badges</p>');
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
