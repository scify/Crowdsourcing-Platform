<?php

namespace App\ViewModels\User;

class EditUser {
    public function __construct(public $user, public $userRoleIds, public $allRoles) {}
}
