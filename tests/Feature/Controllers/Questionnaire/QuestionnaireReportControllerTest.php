<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;
use App\Models\User\UserRole;
use App\Repository\Questionnaire\QuestionnaireRepository;
use Exception;
use Illuminate\Database\QueryException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuestionnaireReportControllerTest extends TestCase {
    #[Test]
    public function view_reports_page_returns_correct_view(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->get(route('questionnaires.reports', ['locale' => 'en', 'questionnaireId' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.questionnaire.reports.reports-with-filters');
        $response->assertViewHas('viewModel');
    }

    #[Test]
    public function get_report_data_for_questionnaire_returns_correct_json_response(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $input = ['questionnaireId' => $questionnaire->id];
        $response = $this->get(route('api.questionnaire.report-data.get', $input));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['view', 'questionnaire', 'responses']]);
    }

    #[Test]
    public function get_report_data_for_questionnaire_handles_query_exception(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $this->mock(QuestionnaireRepository::class, function ($mock): void {
            $mock->shouldReceive('find')->andThrow(new QueryException('', '', [], new Exception('Test Query Exception')));
        });

        $input = ['questionnaireId' => 1];
        $response = $this->get(route('api.questionnaire.report-data.get', $input));

        $response->assertStatus(500);
        $response->assertJson(['data' => 'Error: 0. A Database error occurred.']);
    }

    #[Test]
    public function get_report_data_for_questionnaire_handles_general_exception(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $this->mock(QuestionnaireRepository::class, function ($mock): void {
            $mock->shouldReceive('find')->andThrow(new Exception('Test General Exception', 123));
        });

        $input = ['questionnaireId' => 1];
        $response = $this->get(route('api.questionnaire.report-data.get', $input));

        $response->assertStatus(500);
        $response->assertJson(['data' => 'Error: 123  Test General Exception']);
    }
}
