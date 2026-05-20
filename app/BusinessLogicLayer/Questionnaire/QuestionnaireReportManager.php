<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\User\User;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Reports\QuestionnaireReportRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseAnswerRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\Questionnaire\reports\QuestionnaireReportFilters;
use App\ViewModels\Questionnaire\reports\QuestionnaireReportResults;
use Illuminate\Support\Collection;

class QuestionnaireReportManager {
    public function __construct(
        protected QuestionnaireRepository $questionnaireRepository,
        protected QuestionnaireReportRepository $questionnaireReportRepository,
        protected QuestionnaireResponseAnswerRepository $questionnaireResponseAnswerRepository,
        protected QuestionnaireResponseRepository $questionnaireResponseRepository,
        protected CrowdSourcingProjectAccessManager $crowdSourcingProjectAccessManager,
        protected UserRoleManager $userRoleManager,
    ) {}

    public function getCrowdSourcingProjectReportsViewModel(User $user, $selectedProjectId = null, $selectedQuestionnaireId = null): QuestionnaireReportFilters {
        if ($this->userRoleManager->userHasAdminRole($user)) {
            $questionnaires = $this->questionnaireRepository->all(['*'], 'id', 'desc');
        } else {
            $projectIds = $this->crowdSourcingProjectAccessManager
                ->getProjectsUserHasAccessToEdit($user)
                ->pluck('id')
                ->all();
            $questionnaires = $this->questionnaireRepository->getQuestionnairesForProjects($projectIds);
        }

        return new QuestionnaireReportFilters($questionnaires, $selectedProjectId, $selectedQuestionnaireId);
    }

    public function getQuestionnaireReportViewModel(array $input): QuestionnaireReportResults {
        $questionnaireId = intval($input['questionnaireId']);
        $respondentsRows = $this->questionnaireReportRepository->getRespondentsData($questionnaireId);
        $responses = new Collection;
        $responses_results = $this->questionnaireResponseRepository->allWhere(['questionnaire_id' => $questionnaireId], ['*'], null, null, ['project']);

        foreach ($responses_results as $responses_result) {
            $responseJson = json_decode((string) $responses_result->response_json, true);
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
