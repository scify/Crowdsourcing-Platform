<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireStatisticsManager;
use App\Http\Controllers\Controller;
use App\Models\Questionnaire\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionnaireStatisticsController extends Controller {
    public function __construct(protected QuestionnaireStatisticsManager $questionnaireStatisticsManager) {}

    public function showStatisticsPageForQuestionnaire(string $locale, Questionnaire $questionnaire, int $projectFilter = -1) {
        $viewModel = $this->questionnaireStatisticsManager->getQuestionnaireVisualizationsViewModel($questionnaire, $projectFilter);

        return view('questionnaire.statistics', ['viewModel' => $viewModel]);
    }

    public function showEditStatisticsColorsPage(string $locale, Questionnaire $questionnaire) {
        $viewModel = $this->questionnaireStatisticsManager->getEditQuestionnaireStatisticsColorViewModel($questionnaire);

        return view('backoffice.management.questionnaire.statistics-colors', ['viewModel' => $viewModel]);
    }

    public function saveStatisticsColors(Request $request, string $locale, Questionnaire $questionnaire): RedirectResponse {
        try {
            $this->questionnaireStatisticsManager->saveStatisticsColors($questionnaire, $request->all());
            session()->flash('flash_message_success', 'Colors saved!');
        } catch (\Exception $e) {
            session()->flash('flash_message_error', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());
        } finally {
            return back();
        }
    }
}
