<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\Models\Questionnaire;
use App\Models\ViewModels\Questionnaire\QuestionnaireVisualizations;

class QuestionnaireVisualizationsManager {

    public function getQuestionnaireVisualizationsViewModel(Questionnaire $questionnaire) {
        $project = $questionnaire->project;
        $viewModel = new QuestionnaireVisualizations($project);

        return $viewModel;
    }

}
