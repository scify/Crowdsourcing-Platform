<?php

namespace Tests\Feature\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User\User;
use App\Models\User\UserRole;
use Faker\Factory as Faker;
use Tests\TestCase;

class ProblemControllerTest extends TestCase {
    /**
     * @test A guest cannot access the create page
     */
    public function guestCannotAccessProblemCreatePage() {
        $response = $this->get(route('problems.create', ['locale' => 'en']));

        // 302 is the status code for a redirect (to the login page)
        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test An authenticated non-admin user cannot access the create page
     */
    public function authenticatedNonAdminUserCannotAccessProblemCreatePage() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(403);
    }

    /**
     * @test An admin user can access the create page
     */
    public function adminCanAccessProblemCreatePage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.problem.create-edit.form-page');
    }

    /**
     * @test A contentManager user can access the create page
     */
    public function contentManagerCanAccessProblemCreatePage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.problem.create-edit.form-page');
    }

    /**
     * @test A non-admin user cannot store a problem
     */
    public function nonAdminUserCannotStoreProblem() {
        $user = User::factory()->create();
        $this->be($user);
        $faker = Faker::create();
        // we need a title with no special characters
        $title = $faker->title;
        $description = $title . ' description';
        $response = $this->withoutMiddleware(VerifyCsrfToken::class) // Disable CSRF only
            ->post(route('problems.store', ['locale' => 'en']), [
                'problem-title' => $title,
                'problem-description' => $description,
                'problem-status' => 1,
                'problem-default-language' => 6,
                'problem-image' => null,
                'problem-owner-project' => 4,
            ]);

        $response->assertStatus(403);
    }

    /**
     * @test A content manager can store a problem with valid data in the form (no extra translations)
     */
    public function contentManagerCanStoreProblemWithValidDataWithNoExtraTranslations() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }

    /**
     * @test A content manager can store a problem with valid data in the form, with extra translations as well
     */
    public function contentManagerCanStoreProblemWithValidDataWithExtraTranslations() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }

    /**
     * @test A content manager cannot store a problem with invalid data in the form
     */
    public function contentManagerCannotStoreProblemWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }
}