<?php

namespace App\Notifications;

use App\Models\ViewModels\GamificationBadgeVM;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BadgeActionOccured extends Notification implements ShouldQueue
{
    use Queueable;
    protected $questionnaire;
    protected $badge;
    protected $badgeVM;

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

    public function objectToMail(GamificationBadgeVM $badge,
                           $subject,
                           $greeting,
                           $title,
                           $beforeBadge,
                           $actionText,
                           $actionText2)
    {
        $message = (new MailMessage)
            ->subject('ECAS | ' . $subject)
            ->greeting($greeting)
            ->line($title);

        $message->line('<div style="text-align: center;"><br><b>' . $beforeBadge . '</b><br><br></div>');
        $message->line((String) view('gamification.badge-single', compact('badge')));
        $message->line('<br><p style="text-align: center"><b>' . $actionText . '</b><br>' . $actionText2 . '</p>');
        $message->action('Go to Dashboard', url('/my-dashboard'));
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
