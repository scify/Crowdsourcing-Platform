<?php

declare(strict_types=1);

namespace App\Repository\User;

use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\Repository;

class UserRepository extends Repository {
    /**
     * Specify Model class name
     */
    public function getModelClassName(): string {
        return User::class;
    }

    public function getUser($id) {
        return $this->getModelInstance()->find($id);
    }

    public function getUserWithTrashed($id) {
        return User::withTrashed()->findOrFail($id);
    }

    public function getSingleUserRole($id) {
        return $this->getModelInstance()->find($id)->roles->pluck('id')->first();
    }

    public function getUserByEmail($email) {
        return $this->getModelInstance()->where('email', $email)->first();
    }

    public function updateUser($id, $nickname, array $roleselect, $email): void {
        $user = $this->getModelInstance()->find($id);
        $user->nickname = $nickname;
        $user->email = $email;
        $user->save();

        $this->updateUserRoles($id, $roleselect);
    }

    public function updateUserRoles($userId, array $roleSelect): void {
        $userRoles = UserRole::where('user_id', $userId)->get();
        foreach ($userRoles as $userRole) {
            $userRole->delete();
        }

        if ($roleSelect[0] == null) {
            UserRole::create(['user_id' => $userId, 'role_id' => 3]); // registered user
        } else {
            foreach ($roleSelect as $roleId) {
                UserRole::create(['user_id' => $userId, 'role_id' => $roleId]);
            }
        }
    }

    public function userIsPlatformAdmin($user): bool {
        return ! is_null(UserRole::where('role_id', 1)->where('user_id', $user->id)->first());
    }

    public function getAllUsersWithRole($roleId) {
        return UserRole::with('user')
            ->with('role')
            ->where('role_id', $roleId)
            ->get();
    }

    public function getAllUserRoles() {
        return UserRole::with('user')->with('role')->get();
    }

    public function anonymizeAndDeleteUser(User $user): void {
        $user->email = 'anonymous_deleted_' . $user->id;
        $user->nickname = 'anonymous_deleted_' . $user->id;
        $user->avatar = null;
        $user->save();
        $user->delete();
    }

    public function softDeleteUser(User $user): void {
        $user->email = $user->email . '_deleted_' . $user->id;
        $user->save();
        $user->delete();
    }

    public function getAllUsers() {
        return User::all();
    }

    public function getPlatformUsers($paginationNumber, $filters) {
        $query = User::withTrashed()->with('userRoles');

        if (isset($filters['email'])) {
            $query = $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        $query->whereHas('userRoles', function ($userRoleQuery): void {
            $userRoleQuery->whereIn('role_id', [1, 2, 4]); // platform admin and content manager
        });

        if ($paginationNumber) {
            return $query->paginate($paginationNumber);
        }

        return $query->get();
    }

    public function reActivateUser($user): void {
        $user->restore();
    }
}
