<?php

namespace App\Notifications;

use App\BusinessLogicLayer\CrowdSourcingProjectManager;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class UserRegistered extends Notification
{
    use Queueable;
    private $crowdSourcingProjectManager;
    public function __construct(CrowdSourcingProjectManager $crowdSourcingProjectManager)
    {
        $this->crowdSourcingProjectManager = $crowdSourcingProjectManager;
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
        $activeQuestionnaire = $this->crowdSourcingProjectManager->getActiveQuestionnaireForProject();
        $project = $this->crowdSourcingProjectManager->getCrowdSourcingProject();

        $message = (new MailMessage)
            ->subject('ECAS | Welcome!')
            ->greeting('Thanks for joining the ECAS Crowdsourcing Platform!')
            ->line('<div style="text-align:center; height: 200px;"><img class="badgeImg" style="height: 200px; margin-bottom: 0;" src=' . asset("images/active_participation.png") . '></div>');
        if($activeQuestionnaire) {
            $message->line('<br><p style="text-align: center; margin-bottom: 5px"><b>Are you ready to make an impact?</b></p>');
            $message->line('
            
            <table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tbody><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tbody><tr>
<td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <table border="0" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;"><tbody><tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                                    <a target="_blank" href="' . url('/' . $project->slug . '?open=1') . '" class="button button-blue" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #8BC34A; border-top: 10px solid #8BC34A; border-right: 18px solid #8BC34A; border-bottom: 10px solid #8BC34A; border-left: 18px solid #8BC34A;">Speak Up Now!</a>
                                </td>
                            </tr></tbody></table>
</td>
                </tr></tbody></table>
</td>
    </tr></tbody></table>
            
            ');
        }

        $message->line('<br><p style="text-align: center; margin-bottom: 5px"><b>Visit your Dashboard to see what\'s next:</b></p>');
        $message->action('Go to Dashboard', url('/my-dashboard'));
        return $message;
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
