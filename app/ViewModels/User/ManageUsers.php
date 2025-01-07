<?php

namespace App\ViewModels\User;

class ManageUsers {
    public function __construct(public $users, public $allRoles) {}
}
