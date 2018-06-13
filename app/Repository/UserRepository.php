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

    function getUsersInfoToManage($cms_id, $user_id)
    {
        return UserRole::with('user')->with('role')->whereIn('role_id', [2, 3])
            ->where('cms_id', $cms_id)->where('user_id', '<>', $user_id)->get();
    }

    function getSingleUserInfo($id)
    {
        return $this->getModelInstance()->find($id);
    }

    function getSingleUserRole($id)
    {
        return $this->getModelInstance()->find($id)->roles->pluck('id')->first();
    }

    function getCmsContentManagingRoles()
    {
        return UserRoleLookup::whereIn('id', [2, 3])->get();
    }

    function getUserByEmail($email)
    {
        return $this->getModelInstance()->where('email', $email)->first();
    }

    function getUserRolesForCms($id, $cmsId)
    {
        $user = $this->getModelInstance()->find($id);
        return $user->roles()->where('cms_id', $cmsId)->get();

    }

    function inviteUserToCms($userId, $roleSelect, $cmsId)
    {
        $this->updateUserRolesForCMS($userId, $roleSelect, $cmsId);
    }

    function updateUser($id, $name, $surname, $roleselect, $email, $cms_id)
    {
        $user = $this->getModelInstance()->find($id);
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->save();

        $this->updateUserRolesForCMS($id, $roleselect, $cms_id);
    }

    function updateUserRolesForCMS($userId, $roleSelect, $cmsId)
    {
        $userRolesForCurrentCms = UserRole::where('user_id', $userId)->where('cms_id', $cmsId)->get();
        foreach ($userRolesForCurrentCms as $userRole) {
            // chief or publisher
            if (in_array($userRole->role->id, [2, 3]) !== false)
                $userRole->delete();
        }
        if ($roleSelect)
            UserRole::create(['user_id' => $userId, 'cms_id' => $cmsId, 'role_id' => $roleSelect]);
    }


    function userIsPlatformAdmin($user)
    {
        return !is_null(UserRole::where('role_id', 1)->where('user_id', $user->id)->first());
    }

    function updateLocation($user, $location_name, $lat, $lon)
    {
        $lastLocation = $user->location;
        if ($lastLocation)
            $lastLocation->delete();
        $location = new UserLocation();
        $location->user_id = $user->id;
        $location->location_name = $location_name;
        $location->lat = $lat;
        $location->lon = $lon;
        $location->save();
    }

    public function getAllUsersWithRole($roleId) {
        return UserRole::with('user')
            ->with('role')
            ->where('role_id', $roleId)
            ->get();
    }


}