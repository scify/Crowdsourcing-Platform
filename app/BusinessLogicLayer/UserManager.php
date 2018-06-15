<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\EditUser;
use App\Models\ViewModels\ManageUsers;
use App\Models\ViewModels\UserProfile;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;

class UserManager
{
    private $userRepository;
    private $userRoleRepository;

    public function __construct(UserRepository $userRepository, UserRoleRepository $userRoleRepository) {
        $this->userRepository = $userRepository;
        $this->userRoleRepository = $userRoleRepository;
    }

    function userIsPlatformAdmin($user) {
        return $this->userRepository->userIsPlatformAdmin($user);
    }

    public function getMyProfileData($user) {

        return new UserProfile($user);

    }

    public function getUser($userId) {
        return $this->userRepository->find($userId);
    }

    public function getManageUsersViewModel() {
        $userRolesList = $this->userRoleRepository->getAllUserRolesWithUsers();
        $allRoles = $this->userRoleRepository->getAllUserRoles();
        return new ManageUsers($userRolesList, $allRoles);
    }

    public function getEditUserViewModel($id)
    {
        $user = $this->userRepository->getUser($id);
        $userRoleIds = $user->roles->pluck('id');
        $allRoles = $this->userRoleRepository->getAllUserRoles();
        return new EditUser($user, $userRoleIds, $allRoles);
    }

    public function updateUserRoles($userId, $roleSelect) {
        $this->userRepository->updateUserRolesForCMS($userId, $roleSelect);
    }

    public function deactivateUser($id) {
        $user = $this->userRepository->getUser($id);
        $this->userRepository->softDeleteUser($user);
    }
}
