<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\CrowdSourcingProject;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User\User;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class CrowdSourcingProjectAccessManager {
    public function registerCrowdSourcingProjectPolicies(): void {
        Gate::define('view-landing-page', function (?User $user, string $project_slug): bool {
            $project = $this->crowdSourcingProjectRepository->findBy('slug', $project_slug);

            return $this->shouldShowLandingPageToUser($user, $project);
        });
    }

    public function __construct(protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository, protected UserRoleManager $userRoleManager) {}

    public function getProjectsUserHasAccessToEdit(User $user): Collection {
        $relationships = ['creator', 'language', 'status'];
        if ($this->userRoleManager->userHasAdminRole($user)) {
            return $this->crowdSourcingProjectRepository
                ->allWithTrashed(['*'], 'id', 'desc', $relationships);
        }

        // if the user is content manager, return only the projects created by them
        $projects = $this->crowdSourcingProjectRepository->whereWithTrashed(['user_creator_id' => $user->id], ['*'],
            'id', 'desc', $relationships);

        // TODO remove after INDEU project
        // also add the INDEU projects
        $indeu_project_ids = [28, 29, 30, 31, 32, 33];
        $extra_projects = CrowdSourcingProject::whereIn('id', $indeu_project_ids)->with($relationships)->get();

        // add the extra projects to the list (only if they are not already in the list, search by id of each project)
        $extra_projects->each(function ($extra_project) use ($projects): void {
            if (! $projects->contains('id', $extra_project->id)) {
                $projects->push($extra_project);
            }
        });

        return $projects;
    }

    protected function shouldShowLandingPageToUser($user, CrowdSourcingProject $crowdSourcingProject): bool {
        if (! $crowdSourcingProject->id) {
            return false;
        }

        if ($crowdSourcingProject->status_id === CrowdSourcingProjectStatusLkp::PUBLISHED) {
            return true;
        }

        return $this->userHasAccessToManageProjects($user);
    }

    public function userHasAccessToManageProjects($user): bool {
        if (! $user) {
            return false;
        }

        if ($this->userRoleManager->userHasAdminRole($user)) {
            return true;
        }

        return $this->userRoleManager->userHasContentManagerRole($user);
    }
}
