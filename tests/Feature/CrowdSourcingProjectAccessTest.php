<?php

namespace Tests\Feature;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\User;
use App\Models\UserRole;
use App\Repository\CrowdSourcingProjectRepository;
use Tests\TestCase;

class CrowdSourcingProjectAccessTest extends TestCase {
    protected $crowdSourcingProjectRepository;

    protected function setUp(): void {
        parent::setUp();
        $this->crowdSourcingProjectRepository = $this->app->make(CrowdSourcingProjectRepository::class);
    }


    /**
     * @test
     */
    public function guestCanViewPublishedProjectLandingPage() {
        // get a published project
        $project = $this->crowdSourcingProjectRepository
            ->findBy('status_id', CrowdSourcingProjectStatusLkp::PUBLISHED, 'slug')->first();

        $response = $this->get(route('project.landing-page', $project->slug));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestCannotViewNonPublishedProjectLandingPage() {
        // get a non published project
        $project = $this->crowdSourcingProjectRepository
            ->where([['status_id', '<>', CrowdSourcingProjectStatusLkp::PUBLISHED]], 'slug')->first();

        $response = $this->get(route('project.landing-page', $project->slug));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function authenticatedUserCannotViewNonPublishedProjectLandingPage() {
        $user = factory(User::class)->make();

        $this->be($user);
        // get a non published project
        $project = $this->crowdSourcingProjectRepository
            ->where([['status_id', '<>', CrowdSourcingProjectStatusLkp::PUBLISHED]], 'slug')->first();

        $response = $this->get(route('project.landing-page', $project->slug));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function adminCanViewNonPublishedProjectLandingPage() {
        $user = factory(User::class, 1)
            ->make()
            ->each(function ($user) {
                $user->userRoles()->save(factory(UserRole::class)->make(['user_id' => $user->id, 'role_id' => UserRolesLkp::ADMIN]));
            })->first();

        $this->be($user);
        // get a non published project
        $project = $this->crowdSourcingProjectRepository
            ->where([['status_id', '<>', CrowdSourcingProjectStatusLkp::PUBLISHED]], 'slug')->first();

        $response = $this->get(route('project.landing-page', $project->slug));

        $response->assertStatus(200);
    }
}
