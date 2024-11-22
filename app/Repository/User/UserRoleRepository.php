<?php

namespace App\Repository\User;

use App\Models\User\UserRole;
use App\Models\User\UserRoleLookup;

class UserRoleRepository {
    public function getAllPlatformSpecificRoles() {
        return UserRoleLookup::whereIn('id', [1, 2, 4])->get();
    }

    public function assignRoleToUser($userId, $roleId) {
        $userRole = new UserRole;
        $userRole->user_id = $userId;
        $userRole->role_id = $roleId;
        $userRole->save();

        return $userRole;
    }
}
