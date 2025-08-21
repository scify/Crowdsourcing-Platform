<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Models\User\UserRole;
use App\Models\User\UserRoleLookup;
use Illuminate\Database\Eloquent\Collection;

class UserRoleRepository {
    public function getAllPlatformSpecificRoles(): Collection {
        return UserRoleLookup::whereIn('id', [1, 2, 4])->get();
    }

    public function assignRoleToUser($userId, $roleId): UserRole {
        $userRole = new UserRole;
        $userRole->user_id = $userId;
        $userRole->role_id = $roleId;
        $userRole->save();

        return $userRole;
    }
}
