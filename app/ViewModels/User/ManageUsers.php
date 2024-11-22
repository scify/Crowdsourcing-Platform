<?php

namespace App\ViewModels\User;

class ManageUsers {
    public $users;
    public $allRoles;

    public function __construct($users, $allRoles) {
        $this->users = $users;
        $this->allRoles = $allRoles;
    }
}
