<?php

namespace App\Repository;


use App\Models\User;
use App\Models\UserLocation;
use App\Models\UserRole;
use App\Models\UserRoleLookup;

class UserRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function getModelClassName()
    {
        return User::class;
    }

    function getUser($id) {
        return $this->getModelInstance()->find($id);
    }

    function getUserWithTrashed($id) {
        return User::withTrashed()->find($id);
    }

    function getSingleUserRole($id)
    {
        return $this->getModelInstance()->find($id)->roles->pluck('id')->first();
    }

    function getUserByEmail($email)
    {
        return $this->getModelInstance()->where('email', $email)->first();
    }

    function updateUser($id, $name, $surname, $roleselect, $email)
    {
        $user = $this->getModelInstance()->find($id);
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->save();

        $this->updateUserRoles($id, $roleselect);
    }

    function updateUserRoles($userId, array $roleSelect)
    {
        $userRoles = UserRole::where('user_id', $userId)->get();
        foreach ($userRoles as $userRole) {
            $userRole->delete();
        }
        foreach ($roleSelect as $roleId)
            UserRole::create(['user_id' => $userId, 'role_id' => $roleId]);
    }


    function userIsPlatformAdmin($user)
    {
        return !is_null(UserRole::where('role_id', 1)->where('user_id', $user->id)->first());
    }

    public function getAllUsersWithRole($roleId) {
        return UserRole::with('user')
            ->with('role')
            ->where('role_id', $roleId)
            ->get();
    }


    function getAllUserRoles() {
        return UserRole::with('user')->with('role')->get();
    }

    public function softDeleteUser(User $user) {
        $user->delete();
    }

    public function getAllUsers() {
        return User::all();
    }

    public function getUsersWithTrashed($paginationNumber = null, $filters = null) {
        $query = User::withTrashed();
        if(isset($filters['email']))
            $query = $query->where('email', 'like', '%' . $filters['email'] . '%');
        if($paginationNumber)
            return $query->paginate($paginationNumber);
        return $query->get();
    }

    public function reActivateUser($user) {
        $user->restore();
    }
}