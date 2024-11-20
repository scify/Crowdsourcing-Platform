<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\reports\QuestionnaireReportFilters;
use App\ViewModels\reports\QuestionnaireReportResults;

class QuestionnaireReportManager {
    protected QuestionnaireRepository $questionnaireRepository;
    protected QuestionnaireReportRepository $questionnaireReportRepository;
    protected QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository;
    protected QuestionnaireResponseRepository $questionnaireResponseRepository;

    public function __construct(
        QuestionnaireRepository $questionnaireRepository,
        QuestionnaireReportRepository $questionnaireReportRepository,
        QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository,
        QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->questionnaireReportRepository = $questionnaireReportRepository;
        $this->questionnaireResponseAnswerRepository = $questionnaireResponseAnswerRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getCrowdSourcingProjectReportsViewModel($selectedProjectId = null, $selectedQuestionnaireId = null): QuestionnaireReportFilters {
        $allQuestionnaires = $this->questionnaireRepository->all(['*'], $orderColumn = 'id', $order = 'desc');

        return new QuestionnaireReportFilters($allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId);
    }

    public function getQuestionnaireReportViewModel(array $input): QuestionnaireReportResults {
        $questionnaireId = $input['questionnaireId'];
        $respondentsRows = $this->questionnaireReportRepository->getRespondentsData($questionnaireId);
        $responses = $this->questionnaireResponseRepository->allWhere(['questionnaire_id' => $questionnaireId]);
        $responsesCounts = $this->questionnaireResponseRepository->countResponsesPerProject($questionnaireId);

        return new QuestionnaireReportResults($responses, $respondentsRows, $questionnaireId, $responsesCounts);
    }
}
