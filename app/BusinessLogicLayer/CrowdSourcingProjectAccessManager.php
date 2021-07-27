<?php


namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User;
use App\Repository\CrowdSourcingProjectRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class CrowdSourcingProjectAccessManager {

    protected $crowdSourcingProjectRepository;
    protected $userRoleManager;

    public function registerCrowdSourcingProjectPolicies() {
        Gate::define('view-landing-page', function (?User $user, string $project_slug) {
            $project = $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);
            return $this->shouldShowLandingPageToUser($user, $project);
        });
    }

    public function __construct(CrowdSourcingProjectRepository $crowdSourcingProjectRepository, UserRoleManager $userRoleManager) {
        $this->crowdSourcingProjectRepository = $crowdSourcingProjectRepository;
        $this->userRoleManager = $userRoleManager;
    }

    public function getProjectsUserHasAccessToEdit(User $user): Collection {
        if($this->userRoleManager->userHasAdminRole($user) || $this->userRoleManager->userHasContentManagerRole($user))
            return $this->crowdSourcingProjectRepository->allWithTrashed();
        return $this->crowdSourcingProjectRepository->whereWithTrashed($whereArray = ['user_creator_id' => $user->id]);
    }

    protected function shouldShowLandingPageToUser($user, CrowdSourcingProject $project): bool {
        if(!$project)
            return false;
        if($project->status_id === CrowdSourcingProjectStatusLkp::PUBLISHED)
            return true;
        return $this->userHasAccessToManageProject($user, $project);
    }

    public function userHasAccessToManageProject($user, CrowdSourcingProject $project): bool {
        if(!$user)
            return false;
        return $this->userRoleManager->userHasAdminRole($user) ||
            $this->userRoleManager->userHasContentManagerRole($user);
    }

}
