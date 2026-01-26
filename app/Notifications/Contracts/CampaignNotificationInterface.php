<?php

declare(strict_types=1);

namespace App\Notifications\Contracts;

/**
 * Interface for notifications that can be sent to campaign responders.
 *
 * All notifications used with the NotifyCampaignResponders command
 * must implement this interface to ensure a consistent constructor signature.
 */
interface CampaignNotificationInterface {
    /**
     * Create a new notification instance.
     *
     * @param  string  $projectName  The name of the project/campaign
     * @param  string  $locale  The locale code for the notification (e.g., 'en', 'el')
     */
    public function __construct(string $projectName, string $locale);
}
