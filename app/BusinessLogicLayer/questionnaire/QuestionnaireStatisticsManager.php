<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\Models\Questionnaire;
use App\Models\ViewModels\Questionnaire\QuestionnaireStatistics;
use App\Models\ViewModels\Questionnaire\QuestionnaireStatisticsColors;
use App\Repository\QuestionnaireStatistics\QuestionnaireStatisticsRepositoryMock;
use Illuminate\Support\Facades\Gate;

class QuestionnaireStatisticsManager {

    protected $questionnaireStatisticsRepository;

    public function __construct(QuestionnaireStatisticsRepositoryMock $questionnaireStatisticsRepository) {
        $this->questionnaireStatisticsRepository = $questionnaireStatisticsRepository;
    }


    public function getQuestionnaireVisualizationsViewModel(Questionnaire $questionnaire) {
        $project = $questionnaire->project;
        $questionnaireTotalResponseStatistics = $this->questionnaireStatisticsRepository
            ->getQuestionnaireResponseStatistics($questionnaire->id);
        $numberOfResponsesPerLanguage = $this->questionnaireStatisticsRepository
            ->getNumberOfResponsesPerLanguage($questionnaire->id);
        $statisticsPerQuestion = $this->questionnaireStatisticsRepository
            ->getStatisticsPerQuestion($questionnaire);
        return new QuestionnaireStatistics (
            $questionnaire,
            $project,
            $questionnaireTotalResponseStatistics,
            $numberOfResponsesPerLanguage,
            $statisticsPerQuestion,
            Gate::allows('manage-crowd-sourcing-projects')
        );
    }

    public function getEditQuestionnaireStatisticsColorViewModel(Questionnaire $questionnaire) {
        // load color relationships for questionnaire
        $questionnaire->load(
            'basicStatisticsColors',
            'questionnaireLanguages.language'
        );
        $questionnaire->load(['questions' => function ($query) {
            $query->whereIn('type', ['radiogroup', 'checkbox']);
        }]);
        $questionnaire->questions->load('possibleAnswers');
        //dd($questionnaire);
        return new QuestionnaireStatisticsColors($questionnaire);
    }

}
