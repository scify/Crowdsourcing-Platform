<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 4/23/18
 * Time: 1:19 PM
 */

namespace App\Models\ViewModels;


use App\Models\User;

class UserProfile
{
    public $fullName;
    public $email;

    public function __construct(User $user)
    {
        $this->fullName = $user->name . " " . $user->surname;
        $this->email = $user->email;
    }
}