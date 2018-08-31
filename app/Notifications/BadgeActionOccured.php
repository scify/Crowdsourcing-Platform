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

    private $badgeVM;
    private $subject;
    private $greeting;
    private $title;
    private $beforeBadge;
    private $actionText;
    private $actionText2;

    public function __construct(GamificationBadgeVM $badgeVM,
                                $subject,
                                $greeting,
                                $title,
                                $beforeBadge,
                                $actionText,
                                $actionText2) {
        $this->badgeVM = $badgeVM;
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->title = $title;
        $this->beforeBadge = $beforeBadge;
        $this->actionText = $actionText;
        $this->actionText2 = $actionText2;
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
            ->subject('ECAS | ' . $this->subject)
            ->greeting($this->greeting)
            ->line($this->title);

        $message->line('<div style="text-align: center;"><br><b>' . $this->beforeBadge . '</b><br><br></div>');
        $badge = $this->badgeVM;
        $message->line((String) view('gamification.badge-single', compact('badge')));
        $message->line('<br><p style="text-align: center"><b>' . $this->actionText . '</b><br>' . $this->actionText2 . '</p>');
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
