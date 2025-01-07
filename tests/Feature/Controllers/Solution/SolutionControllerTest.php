<?php

namespace Feature\Controllers\Solution;

use App\BusinessLogicLayer\lkp\SolutionStatusLkp;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\Problem\Problem;
use App\Models\Solution\SolutionTranslation;
use App\Models\User\User;
use Faker\Factory as Faker;
use Tests\TestCase;

class SolutionControllerTest extends TestCase {
    /**
     * @test
     *
     * @group solution-controller-test
     *
     * Test Scenario 1:
     * GIVEN that a user is not authenticated,
     *
     * AND they try to access the solution propose page,
     * THEN they should be redirected to the login page.
     */
    public function test_user_proposal_create_redirects_to_login_page_when_user_is_not_authenticated(): void {
        $response = $this->get('/en/project-slug/problems/problem-slug/solutions/propose');

        $response->assertRedirectContains(route('login', ['locale' => 'en']));
    }

    /**
     * @test
     *
     * @group solution-controller-test
     *
     * Test Scenario 2:
     * GIVEN that a user is authenticated,
     *
     * AND they try to access the solution propose page,
     * THEN they should be able to access the page.
     */
    public function test_user_proposal_create_page_is_accessible_when_user_is_authenticated(): void {
        $user = User::factory()->create();

        // get the problem with id 1
        $problem = Problem::findOrfail(1);
        $route = route('solutions.user-proposal-create', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);

        $response = $this->actingAs($user)->get($route);

        $response->assertOk();
    }

    /**
     * @test
     *
     * @group solution-controller-test
     *
     * Test Scenario 3:
     * GIVEN that a user is authenticated,
     *
     * AND they submit a solution proposal,
     * AND the data is valid,
     * THEN the solution should be stored in the database.
     * AND the solution should be associated with the problem.
     * AND the solution should have an "UNPUBLISHED" status.
     */
    public function test_user_proposal_store_stores_solution_in_database_when_data_is_valid(): void {
        $user = User::factory()->create();

        // get the problem with id 1
        $problem = Problem::findOrfail(1);
        $route = route('solutions.user-proposal-store', ['locale' => 'en', 'project_slug' => $problem->project->slug, 'problem_slug' => $problem->slug]);

        $faker = Faker::create();

        $name = $faker->name;
        $description = $faker->text;

        $response = $this->actingAs($user)->withoutMiddleware(VerifyCsrfToken::class)
            ->post($route, [
                'solution-title' => $name,
                'solution-description' => $description,
                'solution-owner-problem' => 1,
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
}
