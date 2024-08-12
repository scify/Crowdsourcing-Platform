<?php

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\questionnaire\QuestionnaireStatisticsManager;
use App\Http\Controllers\Controller;
use App\Models\Questionnaire\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionnaireStatisticsController extends Controller {
    protected QuestionnaireStatisticsManager $questionnaireStatisticsManager;

    public function __construct(QuestionnaireStatisticsManager $questionnaireStatisticsManager) {
        $this->questionnaireStatisticsManager = $questionnaireStatisticsManager;
    }

    public function showStatisticsPageForQuestionnaire(string $locale, Questionnaire $questionnaire, int $projectFilter = -1) {
        $viewModel = $this->questionnaireStatisticsManager->getQuestionnaireVisualizationsViewModel($questionnaire, $projectFilter);

        return view('questionnaire.statistics', compact(['viewModel']));
    }

    public function showEditStatisticsColorsPage(Questionnaire $questionnaire) {
        $viewModel = $this->questionnaireStatisticsManager->getEditQuestionnaireStatisticsColorViewModel($questionnaire);

        return view('questionnaire.statistics-colors', compact(['viewModel']));
    }

    public function saveStatisticsColors(Request $request, Questionnaire $questionnaire): RedirectResponse {
        try {
            $this->questionnaireStatisticsManager->saveStatisticsColors($questionnaire, $request->all());
            session()->flash('flash_message_success', 'Colors saved!');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', 'Error: ' . $e->getCode() . '  ' . $e->getMessage());
        } finally {
            return back();
        }
    }
}
