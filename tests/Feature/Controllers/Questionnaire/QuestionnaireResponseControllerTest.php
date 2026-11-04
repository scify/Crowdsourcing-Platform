<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireResponseManager;
use App\BusinessLogicLayer\User\UserManager;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\Models\User\UserRole;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class QuestionnaireResponseControllerTest extends TestCase {
    #[Test]
    public function test_store_invalid_data(): void {
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

    #[Test]
    public function test_store_without_authentication_for_non_moderator(): void {
        $questionnaire = $this->createPublishedQuestionnaireOfProject();

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

    #[Test]
    public function test_store_of_moderator(): void {
        // Create a moderator and set as authenticated
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ANSWERS_MODERATOR]))
            ->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = $this->createPublishedQuestionnaireOfProject();

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

    #[Test]
    public function test_store_without_authentication_ignores_cookie_of_registered_user(): void {
        $registeredUser = User::factory()->create();
        $questionnaire = $this->createPublishedQuestionnaireOfProject();

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withCookie(UserManager::$USER_COOKIE_KEY, (string) $registeredUser->id)
            ->post(route('api.questionnaire-responses.store'), [
                'browser_fingerprint_id' => 'test_fingerprint',
                'questionnaire_id' => $questionnaire->id,
                'project_id' => 1,
                'lang' => 'en',
                'moderator' => false,
                'response' => json_encode(['question1' => 5]),
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('questionnaire_responses', [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $registeredUser->id,
        ]);
    }

    #[Test]
    public function test_store_without_authentication_for_non_moderator_with_stored_cookie(): void {
        // Create the anonymous user that the cookie belongs to
        $user = User::create(['nickname' => 'Anonymous_User_' . uniqid(), 'email' => 'Anonymous_User_' . uniqid() . '@crowd.org']);
        // Create a questionnaire
        $questionnaire = $this->createPublishedQuestionnaireOfProject();

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

        // Send POST request to store endpoint, with the (encrypted) anonymous-user cookie
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->withCookie(UserManager::$USER_COOKIE_KEY, (string) $user->id)
            ->post(route('api.questionnaire-responses.store'), $requestData);

        // Assert response status
        $response->assertStatus(200);

        // Assert database has the stored questionnaire response
        $this->assertDatabaseHas('questionnaire_responses', [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);
    }

    #[Test]
    public function test_show_questionnaire_thanks_for_responding_page(): void {
        // Create a user and set as authenticated
        $user = User::factory()->create();
        $this->be($user);

        // Create a questionnaire
        $questionnaire = Questionnaire::factory()->create();

        // Create a questionnaire response for this user and questionnaire
        $response = QuestionnaireResponse::factory()->create([
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $user->id,
        ]);

        // Prepare request data
        $requestData = [
            'project_slug' => CrowdSourcingProject::first()->slug,
            'questionnaire_id' => $questionnaire->id,
            'response_id' => $response->id,
            'locale' => 'en',
        ];

        // Send GET request to the endpoint
        $response = $this->get(route('questionnaire.thanks', $requestData));

        // Assert response status
        $response->assertStatus(200);

        // Assert view is correct
        $response->assertViewIs('questionnaire.thanks_for_responding');
    }

    #[Test]
    public function test_vote_answer_upvote(): void {
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

    #[Test]
    public function test_vote_answer_downvote(): void {
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

    #[Test]
    public function test_vote_answer_ignores_voter_user_id_from_request(): void {
        $voter = User::factory()->create();
        $otherUser = User::factory()->create();
        $questionnaire = Questionnaire::factory()->create();

        $response = $this->actingAs($voter)->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('api.questionnaire.answer-votes.store'), [
                'questionnaire_id' => $questionnaire->id,
                'question_name' => 'question1',
                'respondent_user_id' => $voter->id,
                'voter_user_id' => $otherUser->id,
                'upvote' => true,
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('questionnaire_answer_votes', [
            'questionnaire_id' => $questionnaire->id,
            'voter_user_id' => $voter->id,
        ]);
        $this->assertDatabaseMissing('questionnaire_answer_votes', [
            'questionnaire_id' => $questionnaire->id,
            'voter_user_id' => $otherUser->id,
        ]);
    }

    #[Test]
    public function test_registered_user_cannot_download_questionnaire_responses(): void {
        $questionnaire = Questionnaire::factory()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('questionnaire.responses.download', ['questionnaire_id' => $questionnaire->id]))
            ->assertForbidden();
    }

    #[Test]
    public function test_content_manager_can_download_questionnaire_responses(): void {
        $questionnaire = Questionnaire::factory()->create();
        $contentManager = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::CONTENT_MANAGER]))
            ->create();
        // Only the access rule is under test here, not the (MySQL-specific) export query.
        $this->partialMock(QuestionnaireResponseManager::class)
            ->shouldReceive('getAnswersWithVotesAndVoterInfoForQuestionnaire')
            ->andReturn(collect());

        $this->actingAs($contentManager)
            ->get(route('questionnaire.responses.download', ['questionnaire_id' => $questionnaire->id]))
            ->assertOk();
    }

    #[Test]
    public function test_store_rejects_questionnaire_that_is_not_published(): void {
        $questionnaire = $this->createPublishedQuestionnaireOfProject();
        $questionnaire->update(['status_id' => QuestionnaireStatusLkp::FINALIZED]);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('api.questionnaire-responses.store'), $this->responseData($questionnaire->id, 1))
            ->assertForbidden();
        $this->assertDatabaseMissing('questionnaire_responses', ['questionnaire_id' => $questionnaire->id]);
    }

    #[Test]
    public function test_store_rejects_project_that_the_questionnaire_does_not_belong_to(): void {
        $questionnaire = $this->createPublishedQuestionnaireOfProject();
        $otherProject = CrowdSourcingProject::factory()->create(['status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED]);

        $this->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('api.questionnaire-responses.store'), $this->responseData($questionnaire->id, $otherProject->id))
            ->assertForbidden();
        $this->assertDatabaseMissing('questionnaire_responses', ['questionnaire_id' => $questionnaire->id]);
    }

    #[Test]
    public function test_store_rejects_moderator_flag_from_non_moderator(): void {
        $questionnaire = $this->createPublishedQuestionnaireOfProject();

        $this->actingAs(User::factory()->create())
            ->withoutMiddleware(VerifyCsrfToken::class)
            ->postJson(route('api.questionnaire-responses.store'), [...$this->responseData($questionnaire->id, 1), 'moderator' => true])
            ->assertForbidden();
    }

    private function createPublishedQuestionnaireOfProject(int $projectId = 1): Questionnaire {
        $questionnaire = Questionnaire::factory()->create(['status_id' => QuestionnaireStatusLkp::PUBLISHED]);
        $questionnaire->projects()->attach($projectId);

        return $questionnaire;
    }

    private function responseData(int $questionnaireId, int $projectId): array {
        return [
            'browser_fingerprint_id' => 'test_fingerprint',
            'questionnaire_id' => $questionnaireId,
            'project_id' => $projectId,
            'lang' => 'en',
            'moderator' => false,
            'response' => json_encode(['question1' => 5]),
        ];
    }
}
