<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\questionnaire\QuestionnaireStatisticsManager;
use App\Models\Questionnaire;

class QuestionnaireVisualizationsController extends Controller
{
    protected $questionnaireVisualizationsManager;


    public function __construct(QuestionnaireStatisticsManager $questionnaireVisualizationsManager) {
        $this->questionnaireVisualizationsManager = $questionnaireVisualizationsManager;
    }

    public function showVisualizationsPageForQuestionnaire(Questionnaire $questionnaire) {
        $viewModel = $this->questionnaireVisualizationsManager->getQuestionnaireVisualizationsViewModel($questionnaire);
        return view('questionnaire.visualizations', compact(['viewModel']));
    }
}
