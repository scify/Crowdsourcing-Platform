<?php

namespace Tests\Feature\Controllers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User;
use App\Models\UserRole;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use Faker\Factory as Faker;
use Tests\TestCase;

class CrowdSourcingProjectControllerTest extends TestCase {
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

    /**
     * @test
     */
    public function guestCannotViewNonExistentProjectLandingPage(): void {
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function authenticatedUserCannotViewNonExistentProjectLandingPage() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function adminCannotViewNonExistentProjectLandingPage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function guestCannotViewProjectWithInvalidSlug() {
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function authenticatedUserCannotViewProjectWithInvalidSlug() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function adminCannotViewProjectWithInvalidSlug() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function guestCannotAccessCreatePage() {
        $response = $this->get(route('projects.create'));

        // 302 is the status code for a redirect (to the login page)
        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticatedNonAdminUserCannotAccessCreatePage() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('projects.create'));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanAccessCreatePage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('projects.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.create-edit.form-page');
    }

    /**
     * @test
     */
    public function guestCannotAccessIndexPage() {
        $response = $this->get(route('projects.index'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticatedUserCannotAccessIndexPage() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanAccessIndexPage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('projects.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.index');
    }

    /**
     * @test
     */
    public function guestCannotAccessEditPage() {
        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['project' => $project->id]));

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function authenticatedUserCannotAccessEditPage() {
        $user = User::factory()->make();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['project' => $project->id]));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanAccessEditPage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['project' => $project->id]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.projects.create-edit.form-page');
    }

    /**
     * @test
     */
    public function guestCannotStoreProject() {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('projects.store'), [
                'name' => 'Test Project',
                'description' => 'Test Description',
                'status_id' => 1,
                'slug' => 'test-project',
                'language_id' => 1,
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function nonAdminUserCannotStoreProject() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class) // Disable CSRF only
            ->post(route('projects.store'), [
                'name' => 'Test Project ' . rand(1, 100),
                'description' => 'Test Description',
                'status_id' => 1,
                'slug' => 'test-project-' . rand(1, 100),
                'language_id' => 1,
            ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanStoreProjectWithValidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('projects.store'), [
                'name' => 'Valid Project',
                'description' => 'Valid Description',
                'status_id' => 1,
                'slug' => 'valid-project',
                'language_id' => 1,
                'color_ids' => [1],
                'color_names' => [$faker->name],
                'color_codes' => [$faker->hexColor],
                'motto_subtitle' => $faker->text,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'The project has been successfully created');
        $this->assertDatabaseHas('crowd_sourcing_projects', [
            'slug' => 'valid-project',
        ]);
        $this->assertDatabaseHas('crowd_sourcing_project_translations', [
            'name' => 'Valid Project',
            'description' => 'Valid Description',
        ]);
    }

    /**
     * @test
     */
    public function adminCannotStoreProjectWithExistingData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post(route('projects.store'), [
            'name' => $project->defaultTranslation->name,
            'description' => $project->defaultTranslation->description,
            'status_id' => $project->status_id,
            'slug' => $project->slug,
            'language_id' => $project->defaultTranslation->language_id,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'slug']);
    }

    /**
     * @test
     */
    public function storeProjectWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post(route('projects.store'), [
            'name' => '',
            'description' => '',
            'status_id' => 'invalid',
            'slug' => '',
            'language_id' => 'invalid',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'description', 'status_id', 'language_id']);
    }

    /**
     * @test
     */
    public function guestCannotUpdateProject() {
        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update', ['project' => $project->id]), [
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'status_id' => 1,
            'slug' => 'updated-project',
            'language_id' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticatedUserCannotUpdateProject() {
        $user = User::factory()->make();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update', ['project' => $project->id]), [
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'status_id' => 1,
            'slug' => 'updated-project',
            'language_id' => 1,
        ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanUpdateProjectWithValidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();
        $faker = Faker::create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update', ['project' => $project->id]), [
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'status_id' => 1,
            'slug' => 'updated-project',
            'language_id' => 1,
            'color_ids' => [1],
            'color_names' => [$faker->name],
            'color_codes' => [$faker->hexColor],
            'motto_subtitle' => $faker->text,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'The project has been successfully updated');
        $this->assertDatabaseHas('crowd_sourcing_projects', [
            'id' => $project->id,
            'slug' => 'updated-project',
        ]);
        $this->assertDatabaseHas('crowd_sourcing_project_translations', [
            'project_id' => $project->id,
            'name' => 'Updated Project',
            'description' => 'Updated Description',
        ]);
    }

    /**
     * @test
     */
    public function adminCannotUpdateProjectWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update', ['project' => $project->id]), [
            'name' => '',
            'description' => '',
            'status_id' => 'invalid',
            'slug' => '',
            'language_id' => 'invalid',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['name', 'description', 'status_id', 'language_id']);
    }

    /**
     * @test
     */
    public function adminCannotViewLandingPageDueToException() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ]);

        $this->mock(CrowdSourcingProjectManager::class, function ($mock) {
            $mock->shouldReceive('getCrowdSourcingProjectViewModelForLandingPage')
                ->andThrow(new \Exception('Test Exception'));
        });

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'project_slug' => $project->slug]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_failure', 'Error: 0  Test Exception');
    }
}
