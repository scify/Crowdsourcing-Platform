<?php

namespace App\Http\Controllers;

use App\Models\Questionnaire;
use App\Models\ViewModels\Questionnaire\QuestionnaireVisualizations;

class QuestionnaireVisualizationsController extends Controller
{
    public function showVisualizationsPageForQuestionnaire(Questionnaire $questionnaire) {
        $viewModel = new QuestionnaireVisualizations($questionnaire->project);
        return view('questionnaire.visualizations', compact(['viewModel']));
    }
}
