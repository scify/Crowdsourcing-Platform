<?php

declare(strict_types=1);

namespace App\Http\Controllers\Questionnaire;

use App\BusinessLogicLayer\Questionnaire\QuestionnaireStatisticsManager;
use App\Http\Controllers\Controller;
use App\Models\Questionnaire\Questionnaire;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionnaireStatisticsController extends Controller {
    public function __construct(protected QuestionnaireStatisticsManager $questionnaireStatisticsManager) {}

    public function showStatisticsPageForQuestionnaire(string $locale, Questionnaire $questionnaire, int $projectFilter = -1): View|Factory {
        $questionnaireStatistics = $this->questionnaireStatisticsManager->getQuestionnaireVisualizationsViewModel($questionnaire, $projectFilter);

        return view('questionnaire.statistics', ['viewModel' => $questionnaireStatistics]);
    }

    public function showEditStatisticsColorsPage(string $locale, Questionnaire $questionnaire): View|Factory {
        $questionnaireStatisticsColors = $this->questionnaireStatisticsManager->getEditQuestionnaireStatisticsColorViewModel($questionnaire);

        return view('backoffice.management.questionnaire.statistics-colors', ['viewModel' => $questionnaireStatisticsColors]);
    }

    public function saveStatisticsColors(Request $request, string $locale, Questionnaire $questionnaire): RedirectResponse {
        try {
            $this->questionnaireStatisticsManager->saveStatisticsColors($questionnaire, $request->all());
            session()->flash('flash_message_success', 'Colors saved!');
        } catch (\Exception $exception) {
            session()->flash('flash_message_error', 'Error: ' . $exception->getCode() . '  ' . $exception->getMessage());
        } finally {
            return back();
        }
    }
}
