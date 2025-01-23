<?php

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;

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
            QuestionnaireStatisticsPageVisibilityLkp::RESPONDENTS_ONLY => $user && $this->questionnaireResponseManager->questionnaireResponsesForUserAndQuestionnaireExists($user->id, $questionnaire->id)
                || $this->userIsAdminOrContentManager($user),
            QuestionnaireStatisticsPageVisibilityLkp::ADMIN_AND_CONTENT_MANAGERS_ONLY => $user && $this->userIsAdminOrContentManager($user),
            default => false,
        };
    }

    public function userIsAdminOrContentManager($user) {
        return $this->userRoleManager->userHasAdminRole($user) || $this->userRoleManager->userHasContentManagerRole($user);
    }
}
