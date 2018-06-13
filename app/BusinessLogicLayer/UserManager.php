<?php

namespace App\BusinessLogicLayer;

use App\Models\ViewModels\UserProfile;
use App\Repository\UserRepository;

class UserManager
{
    private $userRepository;

    /**
     * UserManager constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }



    function userIsPlatformAdmin($user)
    {
        return $this->userRepository->userIsPlatformAdmin($user);
    }

    public function getMyProfileData($user)
    {

        return new UserProfile($user);

    }

    public function getUser($userId) {
        return $this->userRepository->find($userId);
    }
}
