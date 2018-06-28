<?php

namespace App\BusinessLogicLayer;


use App\Repository\UserRoleRepository;

class UserRoleManager {

    private $userRoleRepository;

    public function __construct(UserRoleRepository $userRoleRepository) {
        $this->userRoleRepository = $userRoleRepository;
    }

    public function assignRegisteredUserRoleTo($user) {
        return $this->userRoleRepository->assignRoleToUser($user->id, UserRoles::REGISTERED_USER);
    }


}