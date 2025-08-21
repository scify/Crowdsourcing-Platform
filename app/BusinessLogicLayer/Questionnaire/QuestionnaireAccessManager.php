<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\BusinessLogicLayer\User\UserRoleManager;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;

class QuestionnaireAccessManager {
    public function __construct(protected QuestionnaireResponseManager $questionnaireResponseManager, protected UserRoleManager $userRoleManager) {}

    public function userHasAccessToViewQuestionnaireStatisticsPage(?User $user, Questionnaire $questionnaire): bool {
        return match ($questionnaire->statistics_page_visibility_lkp_id) {
            QuestionnaireStatisticsPageVisibilityLkp::PUBLIC => true,
            QuestionnaireStatisticsPageVisibilityLkp::RESPONDENTS_ONLY => ($user && $this->questionnaireResponseManager->questionnaireResponsesForUserAndQuestionnaireExists($user->id, $questionnaire->id))
                || ($user && $this->userIsAdminOrContentManager($user)),
            QuestionnaireStatisticsPageVisibilityLkp::ADMIN_AND_CONTENT_MANAGERS_ONLY => $user && $this->userIsAdminOrContentManager($user),
            default => false,
        };
    }

    public function userIsAdminOrContentManager(\App\Models\User\User $user): bool {
        if ($this->userRoleManager->userHasAdminRole($user)) {
            return true;
        }

        return $this->userRoleManager->userHasContentManagerRole($user);
    }
}
