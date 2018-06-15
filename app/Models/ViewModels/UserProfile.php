<?php

namespace App\Models\ViewModels;


use App\Models\User;

class UserProfile
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}