<?php

declare(strict_types=1);

namespace App\ViewModels;

class MailChimpIntegration {
    public $newsletterList;

    public $registeredUsersList;

    public function __construct($mailChimpLists) {
        $this->newsletterList = $mailChimpLists->where('list_name', 'Newsletter')->first();
        $this->registeredUsersList = $mailChimpLists->where('list_name', 'Registered Users')->first();
    }
}
