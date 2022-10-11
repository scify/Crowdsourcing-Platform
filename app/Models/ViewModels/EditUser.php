<?php

namespace App\Models\ViewModels;

class EditUser {
    public $user;
    public $userRoleIds;
    public $allRoles;

    public function __construct($user, $userRoleIds, $allRoles) {
        $this->user = $user;
        $this->userRoleIds = $userRoleIds;
        $this->allRoles = $allRoles;
    }
}
