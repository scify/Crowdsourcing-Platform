<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\BusinessLogicLayer\questionnaire\QuestionnaireStatisticsManager;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireStatisticsControllerTest extends TestCase {
    use RefreshDatabase;

    protected $seed = true;

    /** @test */
    public function showStatisticsPageForQuestionnaireReturnsCorrectView() {
        $user = User::factory()->create();
        $this->be($user);

        // create a project and a questionnaire with "active" status
        $project = CrowdSourcingProject::factory()->create([
            'status_id' => CrowdSourcingProjectStatusLkp::PUBLISHED,
        ]);
        $questionnaire = Questionnaire::factory()->create([
            'status_id' => QuestionnaireStatusLkp::PUBLISHED,
        ]);

        // Associate the project and questionnaire
        $project->questionnaires()->attach($questionnaire->id);
        $response = $this->get(route('questionnaire.statistics', ['questionnaire' => $questionnaire->id, 'locale' => 'en']));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.statistics');
        $response->assertViewHas('viewModel');
    }

    /** @test */
    public function showEditStatisticsColorsPageReturnsCorrectView() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->get(route('questionnaire.statistics-colors', ['questionnaire' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('questionnaire.statistics-colors');
        $response->assertViewHas('viewModel');
    }

    /** @test */
    public function saveStatisticsColorsSavesColorsAndRedirectsBackWithSuccessMessage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['questionnaire' => $questionnaire->id]), [
                'goal_responses_color' => '#FFFFFF',
                'actual_responses_color' => '#000000',
                'total_responses_color' => '#111111',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Colors saved!');
    }

    /** @test */
    public function saveAllStatisticsColorsSavesColorsAndRedirectsBackWithSuccessMessage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['questionnaire' => $questionnaire->id]), [
                'goal_responses_color' => '#FFFFFF',
                'actual_responses_color' => '#000000',
                'total_responses_color' => '#111111',
                'lang_colors' => [
                    '1' => '#000000',
                    '2' => '#111111',
                ],
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Colors saved!');
    }

    /** @test */
    public function saveStatisticsColorsSavesColorsWithWrongInputAndRedirectsBackWithErrorMessage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['questionnaire' => $questionnaire->id]), [
                'color1' => '#FFFFFF',
                'color2' => '#000000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_failure', 'Error: 0  Undefined array key "goal_responses_color"');
    }

    /** @test */
    public function saveStatisticsColorsHandlesExceptionAndRedirectsBackWithFailureMessage() {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $this->mock(QuestionnaireStatisticsManager::class, function ($mock) {
            $mock->shouldReceive('saveStatisticsColors')->andThrow(new \Exception('Test Exception', 123));
        });

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['questionnaire' => $questionnaire->id]), [
                'color1' => '#FFFFFF',
                'color2' => '#000000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_failure', 'Error: 123  Test Exception');
    }
}
