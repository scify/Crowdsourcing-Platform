<?php

namespace Tests\Feature;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User;
use App\Models\UserRole;
use App\Repository\CrowdSourcingProjectRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrowdSourcingProjectAccessTest extends TestCase {
    use RefreshDatabase;

    protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository;

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

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => $project->slug]));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guestViewsFinalizedProjectLandingPage() {
        // create a "finalized" project from the factory

        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::FINALIZED,
        ]);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => $project->slug]));

        $response->assertStatus(200);
        $response->assertSee('This project is finalized.<br>Thank you for your contribution!', false);
        $response->assertViewIs('crowdsourcing-project.project-unavailable');
    }

    /**
     * @test
     */
    public function authenticatedUserCannotViewNonPublishedProjectLandingPage() {
        $user = User::factory()->make();

        $this->be($user);
        // get a non published project
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::UNPUBLISHED,
        ]);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => $project->slug]));

        $response->assertStatus(200);
        $response->assertSee('This project is unpublished.', false);
        $response->assertViewIs('crowdsourcing-project.project-unavailable');
    }

    /**
     * @test
     */
    public function adminCanViewNonPublishedProjectLandingPage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();

        $this->be($user);
        // get a non published project
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::UNPUBLISHED,
        ]);
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => $project->slug]));

        $response->assertStatus(200);
    }
}
