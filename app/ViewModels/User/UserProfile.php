<?php

declare(strict_types=1);

namespace App\ViewModels\User;

use App\Models\User\User;

class UserProfile {
    /**
     * @var User
     */
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
}
