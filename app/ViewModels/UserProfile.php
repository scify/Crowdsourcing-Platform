<?php

namespace App\ViewModels;

use App\Models\User\User;

class UserProfile {
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
}
