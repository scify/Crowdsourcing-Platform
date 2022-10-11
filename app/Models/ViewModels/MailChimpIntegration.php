<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 8/6/18
 * Time: 1:29 PM
 */

namespace App\Models\ViewModels;

class MailChimpIntegration {
    public $newsletterList;
    public $registeredUsersList;

    public function __construct($mailChimpLists) {
        $this->newsletterList = $mailChimpLists->where('list_name', 'Newsletter')->first();
        $this->registeredUsersList = $mailChimpLists->where('list_name', 'Registered Users')->first();
    }
}
