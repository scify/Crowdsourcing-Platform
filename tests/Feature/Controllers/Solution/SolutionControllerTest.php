<?php

namespace Tests\Feature\Controllers\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Problem\Problem;
use App\Models\Solution\Solution;
use App\Models\Solution\SolutionTranslation;
use App\Models\User\User;
use App\Models\User\UserRole;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SolutionControllerTest extends TestCase {
    /**
     * Test Scenario 1:
     * GIVEN that a user is not authenticated,
     *
     * AND they try to access the solution propose page,
     * THEN they should be able to access the page.
     */
    #[Test]
    public function test_user_proposal_create_is_accessible_when_user_is_not_authenticated(): void {
        // get the first problem that is associated with a project
        $problem = Problem::whereHas('project')->first();
        $route = route('solutions.user-proposal-create', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);
        $response = $this->get($route);

        $response->assertOk();
    }

    /**
     * Test Scenario 2:
     * GIVEN that a user is authenticated,
     *
     * AND they try to access the solution propose page,
     * THEN they should be able to access the page.
     */
    #[Test]
    public function test_user_proposal_create_page_is_accessible_when_user_is_authenticated(): void {
        $user = User::factory()->create();

        // get the first problem that is associated with a project
        $problem = Problem::whereHas('project')->first();
        $route = route('solutions.user-proposal-create', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);

        $response = $this->actingAs($user)->get($route);

        $response->assertOk();
    }

    /**
     * Test Scenario 3:
     * GIVEN that a user is authenticated,
     *
     * AND they submit a solution proposal,
     * AND the data is valid,
     * THEN the solution should be stored in the database.
     * AND the solution should be associated with the problem.
     * AND the solution should have an "UNPUBLISHED" status.
     */
    #[Test]
    public function test_user_proposal_store_stores_solution_in_database_when_data_is_valid(): void {
        $user = User::factory()->create();

        // get the problem with id 1
        $problem = Problem::findOrfail(1);
        $route = route('solutions.user-proposal-store', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);

        $faker = Faker::create();

        $name = $faker->name;
        $description = $faker->text;

        // Mock the HTTP response for reCAPTCHA validation
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'submitSolution',
            ], 200),
        ]);

        $response = $this->actingAs($user)->withoutMiddleware(VerifyCsrfToken::class)
            ->post($route, [
                'solution-title' => $name,
                'solution-description' => $description,
                'solution-owner-problem' => 1,
                'consent-notice' => 'on',
                'translation-notice' => 'on',
                'g-recaptcha-response' => 'valid-recaptcha-response',
            ]);

        $solution = SolutionTranslation::where('title', $name)->first()->solution;

        $response->assertRedirectContains(
            route('solutions.user-proposal-submitted',
                ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug, 'solution_slug' => $solution->slug]
            )
        );

        $response->assertStatus(302);

        $this->assertNotNull($solution);
        $this->assertEquals(SolutionStatusLkp::UNPUBLISHED, $solution->status_id);
        $this->assertEquals($problem->id, $solution->problem_id);
    }

    /**
     * Test Scenario 4:
     * GIVEN that a user submits a solution proposal,
     * AND the description is longer than 600 characters,
     * THEN the request should fail validation on the description field.
     */
    #[Test]
    public function test_user_proposal_store_rejects_description_longer_than_600_characters(): void {
        $user = User::factory()->create();
        $problem = Problem::findOrfail(1);
        $route = route('solutions.user-proposal-store', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);

        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
                'action' => 'submitSolution',
            ], 200),
        ]);

        $response = $this->actingAs($user)->withoutMiddleware(VerifyCsrfToken::class)
            ->post($route, [
                'solution-title' => 'Too long description',
                'solution-description' => str_repeat('a', 601),
                'solution-owner-problem' => 1,
                'consent-notice' => 'on',
                'translation-notice' => 'on',
                'g-recaptcha-response' => 'valid-recaptcha-response',
            ]);

        $response->assertSessionHasErrors('solution-description');
    }

    /**
     * Test Scenario 5:
     * GIVEN that an admin updates a solution from the backoffice,
     * AND the description is exactly 600 characters,
     * THEN the solution should be updated and the description stored.
     */
    #[Test]
    public function test_admin_update_accepts_description_of_600_characters(): void {
        $admin = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $solution = Solution::findOrFail(1);
        $description = str_repeat('a', 600);

        $response = $this->actingAs($admin)->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('solutions.update', ['locale' => 'en', 'solution' => $solution->id]), [
                'solution-title' => $solution->defaultTranslation->title,
                'solution-description' => $description,
                'solution-status' => $solution->status_id,
                'solution-slug' => $solution->slug,
                'solution-owner-problem' => $solution->problem_id,
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('flash_message_success');
        $this->assertEquals($description, $solution->fresh()->defaultTranslation->description);
    }

    /**
     * Test Scenario 6:
     * GIVEN that an admin updates a solution from the backoffice,
     * AND the description is longer than 600 characters,
     * THEN the request should fail validation on the description field.
     */
    #[Test]
    public function test_admin_update_rejects_description_longer_than_600_characters(): void {
        $admin = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $solution = Solution::findOrFail(1);

        $response = $this->actingAs($admin)->withoutMiddleware(VerifyCsrfToken::class)
            ->put(route('solutions.update', ['locale' => 'en', 'solution' => $solution->id]), [
                'solution-title' => $solution->defaultTranslation->title,
                'solution-description' => str_repeat('a', 601),
                'solution-status' => $solution->status_id,
                'solution-slug' => $solution->slug,
                'solution-owner-problem' => $solution->problem_id,
            ]);

        $response->assertSessionHasErrors('solution-description');
    }
}
