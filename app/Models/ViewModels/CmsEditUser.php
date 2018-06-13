<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/4/18
 * Time: 3:04 PM
 */

namespace App\Models\ViewModels;


class CmsEditUser
{
    public $user;
    public $userRole;
    public $allRoles;

    public function __construct($user, $userRole, $allRoles)
    {
        $this->user = $user;
        $this->userRole = $userRole;
        $this->allRoles = $allRoles;
    }
}