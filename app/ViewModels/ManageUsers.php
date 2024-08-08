<?php

namespace App\ViewModels;

class ManageUsers {
    public $users;
    public $allRoles;

    public function __construct($users, $allRoles) {
        $this->users = $users;
        $this->allRoles = $allRoles;
    }
}
