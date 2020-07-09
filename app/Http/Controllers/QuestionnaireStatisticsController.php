<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireStatisticsManager;
use App\Models\Questionnaire;

class QuestionnaireStatisticsController extends Controller
{
    protected $questionnaireStatisticsManager;


    public function __construct(QuestionnaireStatisticsManager $questionnaireStatisticsManager) {
        $this->questionnaireStatisticsManager = $questionnaireStatisticsManager;
    }

    public function showStatisticsVisualizationsPageForQuestionnaire(Questionnaire $questionnaire) {
        $viewModel = $this->questionnaireStatisticsManager->getQuestionnaireVisualizationsViewModel($questionnaire);
        return view('questionnaire.visualizations', compact(['viewModel']));
    }
}
