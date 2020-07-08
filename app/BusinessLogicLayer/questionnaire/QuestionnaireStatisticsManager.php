<?php


namespace App\BusinessLogicLayer\questionnaire;


use App\Models\Questionnaire;
use App\Models\ViewModels\Questionnaire\QuestionnaireStatistics;
use App\Repository\QuestionnaireStatistics\QuestionnaireStatisticsRepositoryMock;

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
        $viewModel = new QuestionnaireStatistics (
            $questionnaire,
            $project,
            $questionnaireTotalResponseStatistics,
            $numberOfResponsesPerLanguage
        );

        return $viewModel;
    }

}
