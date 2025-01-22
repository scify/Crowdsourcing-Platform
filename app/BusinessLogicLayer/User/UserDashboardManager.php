<?php

namespace App\BusinessLogicLayer\User;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectManager;
use App\BusinessLogicLayer\Gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\Gamification\QuestionnaireBadgeProvider;
use App\BusinessLogicLayer\lkp\QuestionnaireTypeLkp;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireAccessManager;
use App\BusinessLogicLayer\Questionnaire\QuestionnaireGoalManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\User\User;
use App\Repository\CrowdSourcingProject\CrowdSourcingProjectRepository;
use App\Repository\LanguageRepository;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\ViewModels\Gamification\GamificationNextStep;
use App\ViewModels\Questionnaire\QuestionnaireSocialShareButtons;
use App\ViewModels\User\UserDashboardViewModel;
use Illuminate\Support\Collection;

class UserDashboardManager {
    public function __construct(protected QuestionnaireRepository $questionnaireRepository, protected PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider, protected QuestionnaireGoalManager $crowdSourcingProjectGoalManager, protected QuestionnaireBadgeProvider $questionnaireBadgeProvider, protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected QuestionnaireAccessManager $questionnaireAccessManager, protected CrowdSourcingProjectManager $crowdSourcingProjectManager, protected LanguageRepository $languageRepository, protected CrowdSourcingProjectRepository $crowdSourcingProjectRepository) {}

    private function questionnaireShouldBeDisplayedInTheDashboard($questionnaire, Collection $userResponses): bool {
        // If the questionnaire is a feedback questionnaire, then we should check
        // if the user has already answered the main project questionnaire, and has not yet answered the feedback questionnaire.
        if ($questionnaire->type_id == QuestionnaireTypeLkp::FEEDBACK_QUESTIONNAIRE) {
            // These are supposed to be answered IF and only IF the main project questionnaire is answered
            // So we only display them the feedback questionnaire to the dashboard
            // IF:
            //a) they are not answered already
            $responseForThisFeedbackQuestionnaireDoesNotExist = $userResponses->first(fn ($u): bool => $u->questionnaire_id == $questionnaire->id) == null;
            //b) and user has responded to the main project questionnaire
            $responseForMainProjectQuestionnaireExists = $userResponses->first(fn ($u): bool => $u->questionnaire->type_id == QuestionnaireTypeLkp::MAIN_QUESTIONNAIRE &&
                    $questionnaire->projects->firstWhere('id', $u->project_id) != null) != null;

            return
                $responseForThisFeedbackQuestionnaireDoesNotExist &&
                $responseForMainProjectQuestionnaireExists;
        }

        return true;
    }

    /**
     * @return Collection<CrowdSourcingProject>
     */
    private function evaluateProjectsThatUserCanContributeTo(Questionnaire $q, Collection $userResponses): Collection {
        //If user has already responded to this questionnaire, then any other actions,
        // like
        // a)  responding to the feedback questionnaire or
        // b) sharing to social media,
        // should be done for the main project that the user answered.
        //
        // For example user answered a questionnaire via page  /gr/air-quality-athens, but the questionnaire can also
        // belongs to project /pt/air-quality-lisbon

        //When opening the dashboard, the user
        // a) should only share the questionnaire via the /gr/air-quality-athens page.
        // b) should provide feedback by navigating to /gr/air-quality-athens.

        // So what we need to do, is to find if there is response for a Main project already.
        $mainResponse = $userResponses->first(fn ($u): bool => $u->questionnaire->type_id == 1 &&
            $q->projects->firstWhere('id', $u->project_id) != null);
        if ($mainResponse) {
            return collect([$q->projects->firstWhere('id', $mainResponse->project_id)]);
        }

        return $q->projects;
    }

    public function getUserDashboardViewModel(User $user): UserDashboardViewModel {
        $userResponses = $this->questionnaireResponseRepository->getQuestionnaireResponsesOfUser($user->id);
        $questionnaireIdsUserHasAnsweredTo = $userResponses->pluck('questionnaire_id')->toArray();
        $questionnairesToBeDisplayedInTheDashboard = $this->getQuestionnairesForDashboard($user, $userResponses, $questionnaireIdsUserHasAnsweredTo);
        $platformWideGamificationBadgesVM = $this->platformWideGamificationBadgesProvider
            ->getPlatformWideGamificationBadgesListVM($user->id, $questionnaireIdsUserHasAnsweredTo);
        $projectsWithActiveProblems = $this->getCrowdSourcingProjectsWithActiveProblems();

        return new UserDashboardViewModel($questionnairesToBeDisplayedInTheDashboard, $projectsWithActiveProblems, $platformWideGamificationBadgesVM, $user);
    }

    protected function getQuestionnairesForDashboard(User $user, Collection $userResponses, array $questionnaireIdsUserHasAnsweredTo): Collection {
        $questionnaires = $this->questionnaireRepository->getActiveQuestionnaires();
        $questionnairesToBeDisplayedInTheDashboard = new Collection;
        foreach ($questionnaires as $questionnaire) {
            if (!$this->questionnaireShouldBeDisplayedInTheDashboard($questionnaire, $userResponses)) {
                continue;
            }

            $questionnaire->goalVM = $this->crowdSourcingProjectGoalManager
                ->getQuestionnaireGoalViewModel($questionnaire, $questionnaire->responses_count);

            $nextBadgeToUnlock = $this->questionnaireBadgeProvider
                ->getNextBadgeToUnlockForQuestionnaire($questionnaire, $user->id, $questionnaireIdsUserHasAnsweredTo);
            $questionnaire->userHasAccessToViewStatisticsPage = $this->questionnaireAccessManager
                ->userHasAccessToViewQuestionnaireStatisticsPage($user, $questionnaire);

            $projectsYouCanContributeTo = $this->evaluateProjectsThatUserCanContributeTo($questionnaire, $userResponses);
            $questionnaire->gamificationNextStepVM = new GamificationNextStep(
                $projectsYouCanContributeTo,
                $nextBadgeToUnlock->getNextStepMessage(),
                $nextBadgeToUnlock->imageFileName,
                true,
                new QuestionnaireSocialShareButtons($questionnaire, $user->id), in_array($questionnaire->id, $questionnaireIdsUserHasAnsweredTo));

            $questionnairesToBeDisplayedInTheDashboard->push($questionnaire);
        }

        return $questionnairesToBeDisplayedInTheDashboard;
    }

    public function getCrowdSourcingProjectsWithActiveProblems(): Collection {
        $language = $this->languageRepository->where(['language_code' => app()->getLocale()]);
        $projects = $this->crowdSourcingProjectRepository->getActiveProjectsWithoutQuestionnaireWithAtLeastOnePublishedProblemWithStatus($language->id);

        foreach ($projects as $project) {
            // if the model has a "translations" relationship and the first item is not null,
            // then set it as the current translation.
            // otherwise, set the default translation as the current translation

            $project->currentTranslation = $project->translations->first() ?? $project->defaultTranslation;

            if ($project->questionnaires->count() > 0) {
                $project->latestQuestionnaire = $project->questionnaires->last();
            }
        }

        return $projects;
    }
}
