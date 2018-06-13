<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Collection;

class ArticlesStoreDigest extends Notification
{
    use Queueable;
    private $articlesStoreData;
    private $publisher;

    public function __construct(Collection $articlesStoreData, User $publisher)
    {
        $this->articlesStoreData = $articlesStoreData;
        $this->publisher = $publisher;
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
        $mailMessage = (new MailMessage)
            ->subject('CPinNg | Weekly digest')
            ->greeting('Hello ' . $this->publisher->name . ' ' . $this->publisher->surname . ',')
            ->line('Since last week, there are ' . $this->articlesStoreData->count() . ' new articles published in the online store.')
            ->line('Check them below:');
        $i = 1;
        foreach ($this->articlesStoreData as $articlesStoreDatum) {
            $mailMessage->line($i . '. ' . $articlesStoreDatum->article->title . ' Cost: ' . $articlesStoreDatum->cost);
            $mailMessage->line($articlesStoreDatum->teaser);
            $mailMessage->line('<img src="' . asset($articlesStoreDatum->teaser_image_path) . '">');
            $i++;
            $mailMessage->line('');
            $mailMessage->line('');
        }

        $mailMessage->action('Visit Online Store', url('online-store'));
        return $mailMessage;
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
