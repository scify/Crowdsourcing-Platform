<?php

declare(strict_types=1);

namespace App\ViewModels\User;

class ManageUsers {
    public function __construct(public $users, public $allRoles) {}
}
