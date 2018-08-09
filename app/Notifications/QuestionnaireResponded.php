<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QuestionnaireResponded extends Notification implements ShouldQueue
{
    use Queueable;

    private $questionnaire;
    private $badgeName;

    /**
     * Create a new notification instance.
     *
     * @param $questionnaire
     * @param $badgeName
     */
    public function __construct($questionnaire, $badgeName)
    {
        $this->questionnaire = $questionnaire;
        $this->badgeName = $badgeName;
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
        if ($this->badgeName) {
            $message
                ->line('You have also unlocked a new badge: "' . $this->badgeName . '". Impressive!')
                ->line('To see the new badge, visit your Dashboard.');
        } else {
            $message->line('Visit your Dashboard, to see what\'s next.');
        }
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
