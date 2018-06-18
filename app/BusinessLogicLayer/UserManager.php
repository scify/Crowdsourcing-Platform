<?php

namespace App\BusinessLogicLayer;

use App\Models\User;
use App\Models\ViewModels\EditUser;
use App\Models\ViewModels\ManageUsers;
use App\Models\ViewModels\UserProfile;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserManager
{
    private $userRepository;
    private $userRoleRepository;
    public static $USERS_PER_PAGE = 10;

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

    public function getManageUsersViewModel($paginationNumber, $filters = null) {
        $users = $this->userRepository->getUsersWithTrashed($paginationNumber, $filters);
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
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->softDeleteUser($user);
    }

    public function reactivateUser($id) {
        $user = $this->userRepository->getUserWithTrashed($id);
        $this->userRepository->reActivateUser($user);
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

    /**
     * @param $data array the form data array
     * @throws HttpException
     */
    public function updateUser($data) {
        $user_id = Auth::User()->id;
        $obj_user = User::find($user_id);
        $obj_user->name = $data['name'];
        $obj_user->surname = $data['surname'];
        $current_password = $obj_user->password;
        if($data['password']) {
            if(Hash::check($data['current_password'], $current_password)) {
                $obj_user->password = Hash::make($data['password']);
            } else {
                throw new HttpException(500, "Current Password Incorrect.");
            }
        }
        $obj_user->save();
    }

    public function getAllUsersWithTrashed() {
        return $this->userRepository->getUsersWithTrashed();
    }

    public function getUsersWithCriteria($paginationNum = null, $data) {
        return $this->userRepository->getUsersWithTrashed($paginationNum, $data);
    }
}
