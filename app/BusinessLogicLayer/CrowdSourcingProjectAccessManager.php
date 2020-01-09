<?php


namespace App\BusinessLogicLayer;


use App\Models\User;
use App\Repository\CrowdSourcingProjectRepository;

class CrowdSourcingProjectAccessManager {

    protected $crowdSourcingProjectRepository;
    protected $userRoleManager;

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository, UserRoleManager $userRoleManager) {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->userRoleManager = $userRoleManager;
    }

    public function getProjectsUserHasAccessToEdit(User $user) {
        if($this->userRoleManager->userHasAdminRole($user))
            return $this->crowdSourcingProjectRepository->all();
        return $this->crowdSourcingProjectRepository->where(['user_creator_id' => $user->id]);
    }

}
