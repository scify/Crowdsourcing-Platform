<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 5/4/18
 * Time: 2:57 PM
 */

namespace App\Models\ViewModels;


class ManageUsers
{
    public $userRolesList;
    public $allRoles;

    public function __construct($userRolesList, $allRoles)
    {
        $this->userRolesList = $userRolesList;
        $this->allRoles = $allRoles;
    }
}