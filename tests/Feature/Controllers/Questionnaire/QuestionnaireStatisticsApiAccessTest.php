<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\Models\User\UserRole;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class QuestionnaireStatisticsApiAccessTest extends TestCase {
    private const string EMAIL_QUESTION_TITLE = 'If you want to be contacted, please indicate your email';

    #[Test]
    public function guest_cannot_read_responses_of_admin_only_questionnaire(): void {
        $questionnaire = $this->createQuestionnaire(QuestionnaireStatusLkp::PUBLISHED, QuestionnaireStatisticsPageVisibilityLkp::ADMIN_AND_CONTENT_MANAGERS_ONLY);

        $this->getJson(route('api.questionnaire.responses.get', $questionnaire->id))->assertForbidden();
        $this->getJson(route('api.questionnaire.answer-votes.get', $questionnaire->id))->assertForbidden();
        $this->getJson(route('api.questionnaire.answer-annotations.get', $questionnaire->id))->assertForbidden();
    }

    #[Test]
    public function guest_cannot_read_responses_of_draft_questionnaire(): void {
        $questionnaire = $this->createQuestionnaire(QuestionnaireStatusLkp::DRAFT, QuestionnaireStatisticsPageVisibilityLkp::PUBLIC);

        $this->getJson(route('api.questionnaire.responses.get', $questionnaire->id))->assertForbidden();
    }

    #[Test]
    public function respondent_can_read_responses_of_respondents_only_questionnaire(): void {
        $questionnaire = $this->createQuestionnaire(QuestionnaireStatusLkp::PUBLISHED, QuestionnaireStatisticsPageVisibilityLkp::RESPONDENTS_ONLY);
        $respondent = User::factory()->create();
        $this->createResponse($questionnaire, $respondent);

        $this->actingAs($respondent)
            ->getJson(route('api.questionnaire.responses.get', $questionnaire->id))
            ->assertOk();
    }

    #[Test]
    public function public_responses_do_not_contain_tracking_data_or_email_answers(): void {
        $questionnaire = $this->createQuestionnaire(QuestionnaireStatusLkp::PUBLISHED, QuestionnaireStatisticsPageVisibilityLkp::PUBLIC);
        $this->createResponse($questionnaire, User::factory()->create());

        $response = $this->getJson(route('api.questionnaire.responses.get', $questionnaire->id));

        $response->assertOk();

        $responseData = $response->json(0);
        $this->assertArrayNotHasKey('browser_ip', $responseData);
        $this->assertArrayNotHasKey('browser_fingerprint_id', $responseData);
        $answers = json_decode((string) $responseData['response_json'], true);
        $this->assertSame('An idea', $answers['idea']);
        $this->assertArrayNotHasKey('email', $answers);
    }

    #[Test]
    public function moderator_sees_email_answers(): void {
        $questionnaire = $this->createQuestionnaire(QuestionnaireStatusLkp::PUBLISHED, QuestionnaireStatisticsPageVisibilityLkp::PUBLIC);
        $this->createResponse($questionnaire, User::factory()->create());
        $moderator = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ANSWERS_MODERATOR]))
            ->create();

        $response = $this->actingAs($moderator)->getJson(route('api.questionnaire.responses.get', $questionnaire->id));

        $answers = json_decode((string) $response->json('0.response_json'), true);
        $this->assertSame('respondent@example.com', $answers['email']);
    }

    private function createQuestionnaire(int $statusId, int $visibilityId): Questionnaire {
        return Questionnaire::factory()->create([
            'status_id' => $statusId,
            'statistics_page_visibility_lkp_id' => $visibilityId,
            'questionnaire_json' => json_encode(['pages' => [['name' => 'page1', 'elements' => [
                ['type' => 'comment', 'name' => 'idea', 'title' => 'Your idea'],
                ['type' => 'text', 'name' => 'email', 'title' => ['default' => self::EMAIL_QUESTION_TITLE]],
            ]]]]),
        ]);
    }

    private function createResponse(Questionnaire $questionnaire, User $respondent): void {
        QuestionnaireResponse::create([
            'questionnaire_id' => $questionnaire->id,
            'project_id' => 1,
            'user_id' => $respondent->id,
            'language_id' => 1,
            'response_json' => json_encode(['idea' => 'An idea', 'email' => 'respondent@example.com']),
            'browser_fingerprint_id' => 'fingerprint-123456',
            'browser_ip' => '203.0.113.7',
        ]);
    }
}
