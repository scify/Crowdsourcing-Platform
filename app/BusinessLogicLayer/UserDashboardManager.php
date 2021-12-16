<?php


namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\gamification\QuestionnaireBadgeProvider;
use App\BusinessLogicLayer\questionnaire\QuestionnaireAccessManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireGoalManager;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\ViewModels\GamificationNextStep;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Models\ViewModels\UserDashboardViewModel;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use Illuminate\Support\Collection;

class UserDashboardManager
{

    protected $questionnaireRepository;
    protected $platformWideGamificationBadgesProvider;
    protected $crowdSourcingProjectGoalManager;
    protected $questionnaireBadgeProvider;
    protected $questionnaireResponseRepository;
    protected $questionnaireAccessManager;
    protected $crowdSourcingProjectTranslationManager;

    public function __construct(QuestionnaireRepository                $questionnaireRepository,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                QuestionnaireGoalManager               $crowdSourcingProjectGoalManager,
                                QuestionnaireBadgeProvider             $questionnaireBadgeProvider,
                                QuestionnaireResponseRepository        $questionnaireResponseRepository,
                                QuestionnaireAccessManager             $questionnaireAccessManager,
                                CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager)
    {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->crowdSourcingProjectGoalManager = $crowdSourcingProjectGoalManager;
        $this->questionnaireBadgeProvider = $questionnaireBadgeProvider;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireAccessManager = $questionnaireAccessManager;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
    }

    private function questionnaireShouldBeDisplayedInTheDashboard($questionnaire, $userResponses): bool
    {
        // It's a feedback questionnaire.
        if ($questionnaire->type_id == 2) {
            // These are supposed to be answered IF and only IF the main project questionnaire is answered
            // So we only display them the feedback questionnaire to the dashboard
            // IF:
            //a) they are not answered already
            $responseForThisFeedbackQuestionnaireDoesNotExist = $userResponses->first(function ($u) use ($questionnaire) {
                    return $u->questionnaire_id == $questionnaire->id;
                }) == null;
            //b) and user has responded to the main project questionnaire
            $responseForMainProjectQuestionnaireExists = $userResponses->first(function ($u) use ($questionnaire) {
                    return $u->questionnaire->type_id == 1 &&
                        $questionnaire->projects->firstWhere("id", $u->project_id) != null;
                }) != null;

            return
                $responseForThisFeedbackQuestionnaireDoesNotExist &&
                $responseForMainProjectQuestionnaireExists;
        }
        return true;
    }

    /**
     * @param $questionnaire
     * @param $userResponses
     * @return Collection<CrowdSourcingProject>
     */
    private function evaluateProjectsThatUserCanContributeTo(Questionnaire $q, $userResponses): Collection
    {
        if ($q->type_id == 2) {
            //This is a feedback questionnaire.
            //Let's find the main project that the user answered. THis could be for example /gr/air-quality-athens
            // We will only display this in the contribute (And we will skip all other projects related with the questionnaire)
            $mainResponse = $userResponses->first(function ($u) use ($q) {
                return $u->questionnaire->type_id == 1 &&
                    $q->projects->firstWhere("id", $u->project_id) != null;
            });
            return collect([$q->projects->firstWhere("id",$mainResponse->project_id)]);
        }
        return $q->projects;
    }

    public function getUserDashboardViewModel($user): UserDashboardViewModel
    {
        $userResponses = $this->questionnaireResponseRepository->getQuestionnaireResponsesOfUser($user->id);
        $questionnaireIdsUserHasAnsweredTo = $userResponses->pluck('questionnaire_id')->toArray();
        $questionnaires = $this->questionnaireRepository->getActiveQuestionnaires();
        $questionnairesToBeDisplayedInTheDashboard = collect([]);
        foreach ($questionnaires as $questionnaire) {

            if (!$this->questionnaireShouldBeDisplayedInTheDashboard($questionnaire, $userResponses))
                continue;

            $questionnaire->goalVM = $this->crowdSourcingProjectGoalManager
                ->getQuestionnaireGoalViewModel($questionnaire, $questionnaire->responses_count);

            $nextUnlockableBadge = $this->questionnaireBadgeProvider
                ->getNextUnlockableBadgeToShowForQuestionnaire($questionnaire, $user->id, $questionnaireIdsUserHasAnsweredTo);
            $questionnaire->userHasAccessToViewStatisticsPage = $this->questionnaireAccessManager
                ->userHasAccessToViewQuestionnaireStatisticsPage($user, $questionnaire);

            $projectsYouCanContributeTo = $this->evaluateProjectsThatUserCanContributeTo($questionnaire, $userResponses);
            $questionnaire->gamificationNextStepVM = new GamificationNextStep(
                $projectsYouCanContributeTo,
                $nextUnlockableBadge->getNextStepMessage(),
                $nextUnlockableBadge->imageFileName,
                true,
                new QuestionnaireSocialShareButtons($projectsYouCanContributeTo, $questionnaire, $user->id),
                in_array($questionnaire->id, $questionnaireIdsUserHasAnsweredTo));

            $questionnairesToBeDisplayedInTheDashboard->push($questionnaire);
        }
        $platformWideGamificationBadgesVM = $this->platformWideGamificationBadgesProvider
            ->getPlatformWideGamificationBadgesListVM($user->id, $questionnaireIdsUserHasAnsweredTo);

        return new UserDashboardViewModel($questionnairesToBeDisplayedInTheDashboard, $platformWideGamificationBadgesVM);
    }

}
