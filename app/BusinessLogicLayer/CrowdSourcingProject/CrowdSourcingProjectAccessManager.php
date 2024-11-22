<?php

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User\User;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class CrowdSourcingProjectAccessManager {
    protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository;
    protected UserRoleManager $userRoleManager;

    public function registerCrowdSourcingProjectPolicies(): void {
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
        $relationships = ['creator', 'language', 'status'];
        if ($this->userRoleManager->userHasAdminRole($user) || $this->userRoleManager->userHasContentManagerRole($user)) {
            return $this->crowdSourcingProjectRepository
                ->allWithTrashed(['*'], 'id', 'desc', $relationships);
        }

        return $this->crowdSourcingProjectRepository->whereWithTrashed(['user_creator_id' => $user->id], ['*'],
            'id', 'desc', $relationships);
    }

    protected function shouldShowLandingPageToUser($user, CrowdSourcingProject $project): bool {
        if (!$project->id) {
            return false;
        }
        if ($project->status_id === CrowdSourcingProjectStatusLkp::PUBLISHED) {
            return true;
        }

        return $this->userHasAccessToManageProjects($user);
    }

    public function userHasAccessToManageProjects($user): bool {
        if (!$user) {
            return false;
        }

        return $this->userRoleManager->userHasAdminRole($user) ||
            $this->userRoleManager->userHasContentManagerRole($user);
    }
}
