<?php

namespace Tests\Feature\Controllers\Problem;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User\User;
use App\Models\User\UserRole;
use Faker\Factory as Faker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProblemControllerTest extends TestCase {
    #[Test]
    public function guest_cannot_access_problem_create_page(): void {
        $response = $this->get(route('problems.create', ['locale' => 'en']));

        // 302 is the status code for a redirect (to the login page)
        $response->assertStatus(302);
        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    #[Test]
    public function authenticated_non_admin_user_cannot_access_problem_create_page(): void {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_access_problem_create_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.problem.create-edit.form-page');
    }

    #[Test]
    public function content_manager_can_access_problem_create_page(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $response = $this->get(route('problems.create', ['locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.problem.create-edit.form-page');
    }

    #[Test]
    public function non_admin_user_cannot_store_problem(): void {
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
     *  A content manager can store a problem with valid data in the form (no extra translations)
     */
    #[Test]
    public function content_manager_can_store_problem_with_valid_data_with_no_extra_translations(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }

    /**
     *  A content manager can store a problem with valid data in the form, with extra translations as well
     */
    #[Test]
    public function content_manager_can_store_problem_with_valid_data_with_extra_translations(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }

    /**
     *  A content manager cannot store a problem with invalid data in the form
     */
    #[Test]
    public function content_manager_cannot_store_problem_with_invalid_data(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        Faker::create();

        // TODO: Implement
        parent::assertTrue(true);
    }
}
