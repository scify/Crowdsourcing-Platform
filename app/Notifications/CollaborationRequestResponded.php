<?php

namespace App\Notifications;

use App\Models\Article;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CollaborationRequestResponded extends Notification
{
    use Queueable;

    private $article;
    private $responder;

    /**
     * Create a new notification instance.
     *
     * @param Article $article
     * @param User $responder
     */
    public function __construct(Article $article, User $responder)
    {
        $this->article = $article;
        $this->responder = $responder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Collaboration Feedback')
            ->greeting('Hello,')
            ->line($this->responder->name . ' ' . $this->responder->surname . ' has sent you feedback for article "' . $this->article->title . '".')
            ->action('View Feedback', route('article.edit', ['id' => $this->article->id]))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
