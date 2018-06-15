<?php

namespace App\Repository;

use App\Models\UserRole;
use App\Models\UserRoleLookup;

class UserRoleRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return UserRole::class;
    }

    function getAllUserRolesWithUsers() {
        return UserRole::with('user')->with('role')->get();
    }

    function getAllUserRoles() {
        return UserRoleLookup::all();
    }
}