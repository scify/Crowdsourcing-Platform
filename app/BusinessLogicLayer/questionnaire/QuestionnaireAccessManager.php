<?php

namespace App\BusinessLogicLayer\questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\BusinessLogicLayer\UserRoleManager;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User;

class QuestionnaireAccessManager {
    protected QuestionnaireResponseManager $questionnaireResponseManager;
    protected UserRoleManager $userRoleManager;

    public function __construct(QuestionnaireResponseManager $questionnaireResponseManager,
        UserRoleManager $userRoleManager) {
        $this->questionnaireResponseManager = $questionnaireResponseManager;
        $this->userRoleManager = $userRoleManager;
    }

    public function userHasAccessToViewQuestionnaireStatisticsPage(?User $user, Questionnaire $questionnaire): bool {
        return match ($questionnaire->statistics_page_visibility_lkp_id) {
            QuestionnaireStatisticsPageVisibilityLkp::PUBLIC => true,
            QuestionnaireStatisticsPageVisibilityLkp::RESPONDENTS_ONLY => $this->questionnaireResponseManager->questionnaireResponsesForUserAndQuestionnaireExists($user->id, $questionnaire->id)
                || $this->userIsAdminOrContentManager($user),
            QuestionnaireStatisticsPageVisibilityLkp::ADMIN_AND_CONTENT_MANAGERS_ONLY => $this->userIsAdminOrContentManager($user),
            default => false,
        };
    }

    public function userIsAdminOrContentManager($user) {
        return $this->userRoleManager->userHasAdminRole($user) || $this->userRoleManager->userHasContentManagerRole($user);
    }
}
