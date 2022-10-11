<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\BusinessLogicLayer\UserRoleManager;
use App\Models\Questionnaire\Questionnaire;

class QuestionnaireAccessManager {
    protected $questionnaireResponseManager;
    protected $userRoleManager;

    public function __construct(QuestionnaireResponseManager $questionnaireResponseManager,
                                UserRoleManager $userRoleManager) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->userRoleManager = $userRoleManager;
    }

    public function userHasAccessToViewQuestionnaireStatisticsPage($user, Questionnaire $questionnaire): bool {
        switch ($questionnaire->statistics_page_visibility_lkp_id) {
            case QuestionnaireStatisticsPageVisibilityLkp::PUBLIC:
                return true;
            case QuestionnaireStatisticsPageVisibilityLkp::RESPONDENTS_ONLY:
                if (! $user) {
                    return false;
                }

                return $this->questionnaireResponseManager->questionnaireResponsesForUserAndQuestionnaireExists($user->id, $questionnaire->id)
                    || $this->userIsAdminOrContentManager($user);
            case QuestionnaireStatisticsPageVisibilityLkp::ADMIN_AND_CONTENT_MANAGERS_ONLY:
                if (! $user) {
                    return false;
                }

                return $this->userIsAdminOrContentManager($user);
            default:
                return false;
        }
    }

    public function userIsAdminOrContentManager($user) {
        return $this->userRoleManager->userHasAdminRole($user) || $this->userRoleManager->userHasContentManagerRole($user);
    }
}
