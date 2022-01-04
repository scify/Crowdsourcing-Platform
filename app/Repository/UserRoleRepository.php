<?php

namespace App\Repository;

use App\Models\UserRole;
use App\Models\UserRoleLookup;

class UserRoleRepository
{


    function getAllUserRolesWithUsers() {
        return UserRole::with('user')->with('role')->get();
    }

    function getAllPlatformSpecificRoles() {
        return UserRoleLookup::whereIn("id",[1,2,4])->get();
    }
    function getAllUserRoles() {
        return UserRoleLookup::all();
    }

    public function assignRoleToUser($userId, $roleId) {
        $userRole = new UserRole;
        $userRole->user_id = $userId;
        $userRole->role_id = $roleId;
        $userRole->save();

        return $userRole;
    }
}
