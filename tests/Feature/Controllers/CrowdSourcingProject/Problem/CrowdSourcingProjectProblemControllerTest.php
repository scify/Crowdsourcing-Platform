<?php

namespace Feature\Controllers\CrowdSourcingProject\Problem;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\User;
use App\Models\UserRole;
use Faker\Factory as Faker;
use Tests\TestCase;

class CrowdSourcingProjectProblemControllerTest extends TestCase {
    /**
     * @test A guest cannot access the create page
     */
    public function guestCannotAccessCreatePage() {
        $response = $this->get(route('problems.create'));

        // 302 is the status code for a redirect (to the login page)
        $response->assertStatus(302);
        $response->assertRedirect(route('login', ['locale' => 'en']));
    }

    /**
     * @test An authenticated non-admin user cannot access the create page
     */
    public function authenticatedNonAdminUserCannotAccessCreatePage() {
        $user = User::factory()->make();
        $this->be($user);

        $response = $this->get(route('problems.create'));

        $response->assertStatus(403);
    }

    /**
     * @test An admin user can access the create page
     */
    public function adminCanAccessCreatePage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $response = $this->get(route('problems.create'));

        $response->assertStatus(200);
        $response->assertViewIs('loggedin-environment.management.problem.create-edit.form-page');
    }

    /**
     * @test An admin user can access the create page
     */
    public function contentManagerCanAccessCreatePage() {
        // TODO: Implement
    }

    /**
     * @test A non-admin user cannot store a project
     */
    public function nonAdminUserCannotStoreProject() {
        // TODO: Implement
    }

    /**
     * @test A content manager can store a project with valid data in the form (no extra translations)
     */
    public function contentManagerCanStoreProjectWithValidDataWithNoExtraTranslations() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
    }

    /**
     * @test A content manager can store a project with valid data in the form, with extra translations as well
     */
    public function contentManagerCanStoreProjectWithValidDataWithExtraTranslations() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
    }

    /**
     * @test A content manager cannot store a project with invalid data in the form
     */
    public function contentManagerCanotStoreProjectWithInvalidData() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        $this->be($user);

        $faker = Faker::create();

        // TODO: Implement
    }
}
