<?php

namespace Tests\Feature\Controllers\Questionnaire;

use App\BusinessLogicLayer\lkp\CrowdSourcingProjectStatusLkp;
use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;
use App\BusinessLogicLayer\lkp\UserRolesLkp;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireStatisticsManager;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;
use App\Models\User\UserRole;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class QuestionnaireStatisticsControllerTest extends TestCase {
    #[Test]
    public function show_statistics_page_for_questionnaire_returns_correct_view(): void {
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

    #[Test]
    public function show_edit_statistics_colors_page_returns_correct_view(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->get(route('questionnaire.statistics-colors', ['locale' => 'en', 'questionnaire' => $questionnaire->id]));

        $response->assertStatus(200);
        $response->assertViewIs('backoffice.management.questionnaire.statistics-colors');
        $response->assertViewHas('viewModel');
    }

    #[Test]
    public function save_statistics_colors_saves_colors_and_redirects_back_with_success_message(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['locale' => 'en', 'questionnaire' => $questionnaire->id]), [
                'goal_responses_color' => '#FFFFFF',
                'actual_responses_color' => '#000000',
                'total_responses_color' => '#111111',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_success', 'Colors saved!');
    }

    #[Test]
    public function save_all_statistics_colors_saves_colors_and_redirects_back_with_success_message(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['locale' => 'en', 'questionnaire' => $questionnaire->id]), [
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

    #[Test]
    public function save_statistics_colors_saves_colors_with_wrong_input_and_redirects_back_with_error_message(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['locale' => 'en', 'questionnaire' => $questionnaire->id]), [
                'color1' => '#FFFFFF',
                'color2' => '#000000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'Error: 0  Undefined array key "goal_responses_color"');
    }

    #[Test]
    public function save_statistics_colors_handles_exception_and_redirects_back_with_failure_message(): void {
        $user = User::factory()
            ->has(UserRole::factory()->state(['role_id' => UserRolesLkp::ADMIN]))
            ->create();
        $this->be($user);

        $questionnaire = Questionnaire::factory()->create();
        $this->mock(QuestionnaireStatisticsManager::class, function ($mock): void {
            $mock->shouldReceive('saveStatisticsColors')->andThrow(new \Exception('Test Exception', 123));
        });

        $response = $this->withoutMiddleware(VerifyCsrfToken::class)
            ->post(route('questionnaire.statistics-colors.store', ['locale' => 'en', 'questionnaire' => $questionnaire->id]), [
                'color1' => '#FFFFFF',
                'color2' => '#000000',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHas('flash_message_error', 'Error: 123  Test Exception');
    }
}
