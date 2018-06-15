<?php

namespace App\BusinessLogicLayer;

use App\Models\User;
use App\Models\ViewModels\EditUser;
use App\Models\ViewModels\ManageUsers;
use App\Models\ViewModels\UserProfile;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;
use Illuminate\Support\Facades\Auth;

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
        $users = $this->userRepository->getAllUsers();
        $allRoles = $this->userRoleRepository->getAllUserRoles();
        return new ManageUsers($users, $allRoles);
    }

    public function getEditUserViewModel($id)
    {
        $user = $this->userRepository->getUser($id);
        $userRoleIds = $user->roles->pluck('id');
        $allRoles = $this->userRoleRepository->getAllUserRoles();
        return new EditUser($user, $userRoleIds, $allRoles);
    }

    public function updateUserRoles($userId, $roleSelect) {
        $this->userRepository->updateUserRoles($userId, $roleSelect);
    }

    public function deactivateUser($id) {
        $user = $this->userRepository->getUser($id);
        $this->userRepository->softDeleteUser($user);
    }

    public function addUserToPlatform($email, $name, $surname, $password, $roleselect) {
        $emailCheck = $this->userRepository->getUserByEmail($email);

        // Check if email exists in db
        if ($emailCheck) {
            // If email exists, update roles
             $this->userRepository->updateUserRoles($emailCheck->id, $roleselect);
            return "__USER_UPDATED";
        } else {
            // If user email does not exist in db, notify for registration.
            $user = User::create([
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            $user->save();
            $this->userRepository->updateUserRoles($user->id, $roleselect);
            return "__USER_ADDED";
        }
    }
}
