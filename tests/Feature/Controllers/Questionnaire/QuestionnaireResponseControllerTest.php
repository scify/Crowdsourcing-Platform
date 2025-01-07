<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\User\UserManager;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use Tests\TestCase;

class QuestionnaireResponseControllerTest extends TestCase {
    /** @test */
    public function test_store_invalid_data() {
        $user = User::factory()->create();
        $this->be($user);

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('api.questionnaire-responses.store'), [
                'browser_fingerprint_id' => '',
                'questionnaire_id' => 'invalid',
                'project_id' => 'invalid',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['browser_fingerprint_id', 'questionnaire_id', 'project_id']);
    }

    /** @test */
    public function test_store_without_authentication_for_non_moderator() {
        $questionnaire = Questionnaire::factory()->create();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('api.questionnaire-responses.store'), [
                'browser_fingerprint_id' => 'test_fingerprint',
                'questionnaire_id' => $questionnaire->id,
                'project_id' => 1,
                'lang' => 'en',
                'moderator' => false,
                'response' => json_encode([
                    'question1' => 5,
                    'question5' => 'item1',
                    'question4' => [
                        'item1' => 'answer1',
                        'item2' => 'answer2',
                    ],
                ]),
            ]);

        // since in case of non-logged in user we create an anonymous user, the user that responded is the
        // latest user inserted in the Database.

        // get the latest user:
        $user = User::latest('id')->first();

        $response->assertStatus(200);
        $this->assertDatabaseHas('questionnaire_responses', [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function test_store_of_moderator() {
        // Create a user and set as authenticated
        $user = User::factory()->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Prepare request data
        $requestData = [
            'browser_fingerprint_id' => 'unique_fingerprint',
            'questionnaire_id' => $questionnaire->id,
            'project_id' => 1,
            'moderator' => true,
            'lang' => 'en',
            'response' => json_encode([
                'question1' => 5,
                'question5' => 'item1',
                'question4' => [
                    'item1' => 'answer1',
                    'item2' => 'answer2',
                ],
            ]),
        ];

        // Send POST request to store endpoint
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire-responses.store'), $requestData);

        // Assert response status
        $response->assertStatus(200);

        // Assert database has the stored questionnaire response
        $this->assertDatabaseHas('questionnaire_responses', [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function test_store_without_authentication_for_non_moderator_with_stored_cookie() {
        // Create a user
        $user = User::factory()->create();

        // Set a cookie with the user's ID
        $_COOKIE[UserManager::$USER_COOKIE_KEY] = $user->id;
        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Prepare request data
        $requestData = [
            'browser_fingerprint_id' => 'test_fingerprint',
            'questionnaire_id' => $questionnaire->id,
            'project_id' => 1,
            'lang' => 'en',
            'moderator' => false,
            'response' => json_encode([
                'question1' => 5,
                'question5' => 'item1',
                'question4' => [
                    'item1' => 'answer1',
                    'item2' => 'answer2',
                ],
            ]),
        ];

        // Send POST request to store endpoint
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire-responses.store'), $requestData);

        // Assert response status
        $response->assertStatus(200);

        // Assert database has the stored questionnaire response
        $this->assertDatabaseHas('questionnaire_responses', [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function test_show_questionnaire_thanks_for_responding_page() {
        // Create a user and set as authenticated
        $user = User::factory()->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Create a questionnaire response for this user and questionnaire
        QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        // Prepare request data
        $requestData = [
            'project_slug' => CrowdSourcingProject::first()->slug,
            'questionnaire_id' => $questionnaire->id,
            'locale' => 'en',
        ];

        // Send GET request to the endpoint
        $response = $this->get(route('questionnaire.thanks', $requestData));

        // Assert response status
        $response->assertStatus(200);

        // Assert view is correct
        $response->assertViewIs('questionnaire.thanks_for_responding');
    }

    /** @test */
    public function test_vote_answer_upvote() {
        // Create a user and set as authenticated
        $user = User::factory()->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Prepare request data for upvoting
        $requestData = [
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user->id,
            'voter_user_id' => $user->id,
            'upvote' => true,
        ];

        // Send POST request to voteAnswer endpoint
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.answer-votes.store'), $requestData);

        // Assert response status
        $response->assertStatus(200);

        // Assert database has the stored vote
        $this->assertDatabaseHas('questionnaire_answer_votes', [
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user->id,
            'voter_user_id' => $user->id,
            'upvote' => true,
        ]);
    }

    /** @test */
    public function test_vote_answer_downvote() {
        // Create a user and set as authenticated
        $user = User::factory()->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Prepare request data for downvoting
        $requestData = [
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user->id,
            'voter_user_id' => $user->id,
            'upvote' => false,
        ];

        // Send POST request to voteAnswer endpoint
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.answer-votes.store'), $requestData);

        // Assert response status
        $response->assertStatus(200);

        // Assert database has the stored vote
        $this->assertDatabaseHas('questionnaire_answer_votes', [
            'questionnaire_id' => $questionnaire->id,
            'question_name' => 'question1',
            'respondent_user_id' => $user->id,
            'voter_user_id' => $user->id,
            'upvote' => false,
        ]);
    }
}
