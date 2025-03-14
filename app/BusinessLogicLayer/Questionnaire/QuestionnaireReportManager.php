<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\Questionnaire\reports\QuestionnaireReportFilters;
use App\ViewModels\Questionnaire\reports\QuestionnaireReportResults;
use Illuminate\Support\Collection;

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
        $allQuestionnaires = $this->questionnaireRepository->all(['*'], 'id', 'desc');

        return new QuestionnaireReportFilters($allQuestionnaires, $selectedProjectId, $selectedQuestionnaireId);
    }

    public function getQuestionnaireReportViewModel(array $input): QuestionnaireReportResults {
        $questionnaireId = $input['questionnaireId'];
        $respondentsRows = $this->questionnaireReportRepository->getRespondentsData($questionnaireId);
        $responses = new Collection;
        $responses_results = $this->questionnaireResponseRepository->allWhere(['questionnaire_id' => $questionnaireId], ['*'], null, null, ['project']);

        foreach ($responses_results as $responses_result) {
            $responseJson = json_decode($responses_result->response_json, true);
            $campaignName = ['campaign_name' => $responses_result->project->defaultTranslation->name];
            $responseJson = array_merge($campaignName, $responseJson);
            unset($responses_result->project);
            $responses_result->response_json = json_encode($responseJson);
            $responses[] = $responses_result;
        }

        $responsesCounts = $this->questionnaireResponseRepository->countResponsesPerProject($questionnaireId);

        return new QuestionnaireReportResults($responses, $respondentsRows, $questionnaireId, $responsesCounts);
    }
}
