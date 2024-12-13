<?php

namespace Feature\Controllers\Solution;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\Solution\Solution;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\Solution\SolutionUpvoteRepository;
use Tests\TestCase;

class SolutionAPIControllerTest extends TestCase {
    protected SolutionUpvoteRepository $solutionUpvoteRepository;

    public function setUp(): void {
        parent::setUp();
        $this->solutionUpvoteRepository = $this->app->make(SolutionUpvoteRepository::class);
    }

    /**
     * @test
     *
     * @group solutions
     *
     * Test Scenario 1:
     * GIVEN that a Project Campaign has some published Problems associated with it,
     *
     * AND there exist published Solutions associated with the Problems,
     *
     * WHEN the get solutions api endpoint is called with the problem id,
     *
     * THEN the response should contain the Solutions associated with the Problem.
     *
     * @return void
     */
    public function test_get_solutions_for_problem_landing_page() {
        $problem_id = 1;
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // set the app locale
        app()->setLocale('en');

        // Act
        $response = $this->get(route('api.solutions.get', ['problem_id' => $problem_id]));

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'solutions' => [
                '*' => [
                    'id',
                    'problem_id',
                    'slug',
                    'img_url',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'status_id',
                    'user_creator_id',
                    'default_translation',
                    'translations',
                    'upvotes_count',
                    'current_translation',
                    'upvoted_by_current_user',
                ]],
        ]);
    }

    /**
     * @test
     *
     * @group solutions
     *
     * Test Scenario 1:
     * GIVEN that a Project Campaign has some published Problems associated with it,
     *
     * AND there exist published Solutions associated with the Problems,
     *
     * AND the user has already upvoted some of the Solutions,
     *
     * WHEN the get solutions api endpoint is called with the problem id,
     *
     * THEN the response should contain the Solutions associated with the Problem,
     * and the upvoted_by_current_user field should be set to true for the Solutions that the user has upvoted.
     *
     * @return void
     */
    public function test_get_solutions_for_problem_landing_page_with_upvoted_solutions() {
        $problem_id = 1;
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // set an upvoted solution
        $solution_id = 1;
        $data = [
            'solution_id' => $solution_id,
            'user_voter_id' => $user->id,
        ];
        $this->solutionUpvoteRepository->updateOrCreate($data, $data);

        // set the app locale
        app()->setLocale('en');

        // Act
        $response = $this->get(route('api.solutions.get', ['problem_id' => $problem_id]));

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'solutions' => [
                '*' => [
                    'id',
                    'problem_id',
                    'slug',
                    'img_url',
                    'created_at',
                    'updated_at',
                    'deleted_at',
                    'status_id',
                    'user_creator_id',
                    'default_translation',
                    'translations',
                    'upvotes_count',
                    'current_translation',
                    'upvoted_by_current_user',
                ],
            ],
        ]);
        // assert also that the upvoted_by_current_user field is set to true for the upvoted solution
        $solutions = $response->json('solutions');
        $upvoted_solution = collect($solutions)->firstWhere('id', $solution_id);
        $this->assertTrue($upvoted_solution['upvoted_by_current_user']);
    }

    /**
     * @test
     *
     * @group solutions
     *
     * Test Scenario 2:
     * GIVEN that a user is logged in,
     * AND the user has not upvoted the Solution,
     * WHEN the user upvotes the Solution,
     * THEN the votes  of the Solution should be incremented by 1,
     * AND the solution should be marked as upvoted by the user.
     * AND the user votes for the project should be decremented by 1.
     *
     * @return void
     */
    public function test_upvote_solution() {
        // create a new solution and tie it to a problem with id 1
        $solution = Solution::factory()->create(['problem_id' => 1]);

        // if the corresponding project is deleted, restore it
        $project = $solution->problem->project;
        if ($project->deleted_at) {
            $project->restore();
        }

        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // set the app locale
        app()->setLocale('en');

        // Act
        $response = $this->post(route('api.solutions.vote-downvote'), ['solution_id' => $solution->id]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'solution_votes' => 1,
            'upvote' => true,
            'user_votes_left' => 4,
        ]);
        // ensure that the records were created in the database
        $this->assertDatabaseHas('solution_upvotes', [
            'solution_id' => $solution->id,
            'user_voter_id' => $user->id,
        ]);
    }

    /**
     * @test
     *
     * @group solutions
     *
     * Test Scenario 3: (Downvote, or remove upvote)
     * GIVEN that a user is logged in,
     * AND the user has already upvoted the Solution,
     * WHEN the user votes the Solution,
     * THEN the votes  of the Solution should be decremented by 1,
     * AND the solution should be marked as not voted by the user.
     * AND the user votes for the project should be incremented by 1.
     *
     * @return void
     */
    public function test_downvote_solution() {
        // create a new solution and tie it to a problem with id 1
        $solution = Solution::factory()->create(['problem_id' => 1]);

        // if the corresponding project is deleted, restore it
        $project = $solution->problem->project;
        if ($project->deleted_at) {
            $project->restore();
        }

        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::REGISTERED_USER]))
            ->create();
        $this->be($user);

        // set the app locale
        app()->setLocale('en');

        // set the user as having upvoted the solution
        $data = [
            'solution_id' => $solution->id,
            'user_voter_id' => $user->id,
        ];
        $this->solutionUpvoteRepository->updateOrCreate($data, $data);

        // Act
        $response = $this->post(route('api.solutions.vote-downvote'), ['solution_id' => $solution->id]);

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'solution_votes' => 0,
            'upvote' => false,
            'user_votes_left' => 5,
        ]);
        // ensure that the records were deleted in the database
        $this->assertDatabaseMissing('solution_upvotes', [
            'solution_id' => $solution->id,
            'user_voter_id' => $user->id,
        ]);
    }
}
