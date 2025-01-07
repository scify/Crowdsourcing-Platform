<?php

namespace Feature\Controllers\CrowdSourcingProject;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
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
    public function guest_can_view_published_project_landing_page(): void {
        $project = $this->crowdSourcingProjectRepository
            ->findBy('status_id', CrowdSourcingProjectStatusLkp::PUBLISHED, 'slug')->first();

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guest_views_finalized_project_landing_page(): void {
        // create a "finalized" project from the factory

        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::FINALIZED,
        ]);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        $response->assertStatus(200);
        $response->assertSee('This campaign is finalized.<br>Thank you for your contribution!', false);
        $response->assertViewIs('crowdsourcing-project.project-unavailable');
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_view_non_published_project_landing_page(): void {
        $user = User::factory()->make();

        $this->be($user);
        // get a non published project
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::UNPUBLISHED,
        ]);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        $response->assertStatus(200);
        $response->assertSee('This campaign is not published yet.', false);
        $response->assertViewIs('crowdsourcing-project.project-unavailable');
    }

    /**
     * @test
     */
    public function admin_can_view_non_published_project_landing_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();

        $this->be($user);
        // get a non published project
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::UNPUBLISHED,
        ]);
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function guest_cannot_view_non_existent_project_landing_page(): void {
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_view_non_existent_project_landing_page(): void {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function admin_cannot_view_non_existent_project_landing_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'non-existent-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function guest_cannot_view_project_with_invalid_slug(): void {
        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_view_project_with_invalid_slug(): void {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function admin_cannot_view_project_with_invalid_slug(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => 'invalid-slug']));

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function guest_cannot_access_create_page(): void {
        $response = $this->get(route('projects.create', ['locale' => 'en']));

        // 302 is the status code for a redirect (to the login page)
        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticated_non_admin_user_cannot_access_create_page(): void {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('projects.create', ['locale' => 'en']));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_access_create_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('projects.create', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.crowdsourcing-project.create-edit.form-page');
    }

    /**
     * @test
     */
    public function guest_cannot_access_index_page(): void {
        $response = $this->get(route('projects.index', ['locale' => 'en']));

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_access_index_page(): void {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('projects.index', ['locale' => 'en']));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_access_index_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('projects.index', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.crowdsourcing-project.index');
    }

    /**
     * @test
     */
    public function guest_cannot_access_edit_page(): void {
        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['locale' => 'en', 'project' => $project->id]));

        $response->assertStatus(302);
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_access_edit_page(): void {
        $user = User::factory()->make();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['locale' => 'en', 'project' => $project->id]));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_access_edit_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->get(route('projects.edit', ['locale' => 'en', 'project' => $project->id]));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.crowdsourcing-project.create-edit.form-page');
    }

    /**
     * @test
     */
    public function guest_cannot_store_project(): void {
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('projects.store', ['locale' => 'en']), [
                'name' => 'Test Project',
                'description' => 'Test Description',
                'status_id' => 1,
                'slug' => 'test-project',
                'language_id' => 1,
            ]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function non_admin_user_cannot_store_project(): void {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();
        // we need a name with no special characters
        $name = $faker->name;
        $slug = Str::slug($name);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class) // Disable CSRF only
            ->post(route('projects.store', ['locale' => 'en']), [
                'name' => $name,
                'description' => 'Test Description',
                'status_id' => 1,
                'slug' => $slug,
                'language_id' => 1,
            ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_store_project_with_valid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $faker = Faker::create();
        $name = $faker->name;
        $slug = Str::slug($name);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('projects.store', ['locale' => 'en']), [
                'name' => $name,
                'description' => 'Valid Description',
                'status_id' => 1,
                'slug' => $slug,
                'language_id' => 1,
                'color_ids' => [1],
                'color_names' => [$faker->name],
                'color_codes' => [$faker->hexColor],
                'motto_title' => $faker->name,
                'motto_subtitle' => $faker->text,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'The project has been successfully created');
        $this->assertDatabaseHas('crowd_sourcing_projects', [
            'slug' => $slug,
        ]);
        $this->assertDatabaseHas('crowd_sourcing_project_translations', [
            'name' => $name,
            'description' => 'Valid Description',
        ]);
    }

    /**
     * @test
     */
    public function admin_cannot_store_project_with_existing_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post(route('projects.store', ['locale' => 'en']), [
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
    public function store_project_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->post(route('projects.store', ['locale' => 'en']), [
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
    public function guest_cannot_update_project(): void {
        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update',
            ['locale' => 'en', 'project' => $project->id]), [
                'name' => 'Updated Project',
                'description' => 'Updated Description',
                'status_id' => 1,
                'slug' => 'updated-project',
                'language_id' => 1,
            ]);

        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_update_project(): void {
        $user = User::factory()->make();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();
        $faker = Faker::create();
        $name = $faker->name;
        $slug = Str::slug($name);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update',
            ['locale' => 'en', 'project' => $project->id]), [
                'name' => $name,
                'description' => 'Updated Description',
                'status_id' => 1,
                'slug' => $slug,
                'language_id' => 1,
            ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function admin_can_update_project_with_valid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();
        $faker = Faker::create();
        $name = $faker->name;
        $slug = Str::slug($name);
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update',
            ['locale' => 'en', 'project' => $project->id]), [
                'name' => $name,
                'description' => 'Updated Description',
                'status_id' => 1,
                'slug' => $slug,
                'language_id' => 1,
                'color_ids' => [1],
                'color_names' => [$faker->name],
                'color_codes' => [$faker->hexColor],
                'motto_title' => $faker->name,
                'motto_subtitle' => $faker->text,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'The project has been successfully updated');
        $this->assertDatabaseHas('crowd_sourcing_projects', [
            'id' => $project->id,
            'slug' => $slug,
        ]);
        $this->assertDatabaseHas('crowd_sourcing_project_translations', [
            'project_id' => $project->id,
            'name' => $name,
            'description' => 'Updated Description',
        ]);
    }

    /**
     * @test
     */
    public function admin_cannot_update_project_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)->put(route('projects.update',
            ['locale' => 'en', 'project' => $project->id]), [
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
    public function admin_cannot_view_landing_page_due_to_exception(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ]);

        $this->mock(CrowdSourcingProjectManager::class, function ($mock): void {
            $mock->shouldReceive('getCrowdSourcingProjectViewModelForLandingPage')
                ->andThrow(new \Exception('Test Exception'));
        });

        $response = $this->get(route('project.landing-page', ['locale' => 'en', 'slug' => $project->slug]));

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'Error: 0  Test Exception');
    }
}
