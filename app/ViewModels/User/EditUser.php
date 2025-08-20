<?php

declare(strict_types=1);

namespace App\ViewModels\User;

class EditUser {
    public function __construct(public $user, public $userRoleIds, public $allRoles) {}
}
