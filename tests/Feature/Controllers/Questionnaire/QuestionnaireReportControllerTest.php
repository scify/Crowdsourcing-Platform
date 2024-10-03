<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use App\Models\UserRole;
use App\Repository\Questionnaire\QuestionnaireRepository;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireReportControllerTest extends TestCase {
    use RefreshDatabase;

    protected $seed = true;

    /** @test */
    public function viewReportsPageReturnsCorrectView() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->get(route('questionnaires.reports', ['questionnaireId' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.reports.reports-with-filters');
        $response->assertViewHas('viewModel');
    }

    /** @test */
    public function getReportDataForQuestionnaireReturnsCorrectJsonResponse() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $input = ['questionnaireId' => $questionnaire->id];
        $response = $this->get(route('questionnaire.get-report-data', $input));

        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['view', 'questionnaire', 'responses']]);
    }

    /** @test */
    public function getReportDataForQuestionnaireHandlesQueryException() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $this->mock(QuestionnaireRepository::class, function ($mock) {
            $mock->shouldReceive('find')->andThrow(new QueryException('', '', [], new Exception('Test Query Exception')));
        });

        $input = ['questionnaireId' => 1];
        $response = $this->get(route('questionnaire.get-report-data', $input));

        $response->assertStatus(500);
        $response->assertJson(['data' => 'Error: 0. A Database error occurred.']);
    }

    /** @test */
    public function getReportDataForQuestionnaireHandlesGeneralException() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $this->mock(QuestionnaireRepository::class, function ($mock) {
            $mock->shouldReceive('find')->andThrow(new Exception('Test General Exception', 123));
        });

        $input = ['questionnaireId' => 1];
        $response = $this->get(route('questionnaire.get-report-data', $input));

        $response->assertStatus(500);
        $response->assertJson(['data' => 'Error: 123  Test General Exception']);
    }
}
