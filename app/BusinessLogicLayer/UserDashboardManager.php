<?php


namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectTranslationManager;
use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\gamification\QuestionnaireBadgeProvider;
use App\BusinessLogicLayer\questionnaire\QuestionnaireAccessManager;
use App\BusinessLogicLayer\questionnaire\QuestionnaireGoalManager;
use App\Models\ViewModels\GamificationNextStep;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Models\ViewModels\UserDashboardViewModel;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;

class UserDashboardManager {

    protected $questionnaireRepository;
    protected $currentQuestionnaireCalculator;
    protected $platformWideGamificationBadgesProvider;
    protected $crowdSourcingProjectGoalManager;
    protected $questionnaireBadgeProvider;
    protected $questionnaireResponseRepository;
    protected $questionnaireAccessManager;
    protected $crowdSourcingProjectTranslationManager;

    public function __construct(QuestionnaireRepository                $questionnaireRepository,
                                CurrentQuestionnaireProvider           $currentQuestionnaireCalculator,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                QuestionnaireGoalManager               $crowdSourcingProjectGoalManager,
                                QuestionnaireBadgeProvider             $questionnaireBadgeProvider,
                                QuestionnaireResponseRepository        $questionnaireResponseRepository,
                                QuestionnaireAccessManager             $questionnaireAccessManager,
                                CrowdSourcingProjectTranslationManager $crowdSourcingProjectTranslationManager) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->currentQuestionnaireCalculator = $currentQuestionnaireCalculator;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->crowdSourcingProjectGoalManager = $crowdSourcingProjectGoalManager;
        $this->questionnaireBadgeProvider = $questionnaireBadgeProvider;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->questionnaireAccessManager = $questionnaireAccessManager;
        $this->crowdSourcingProjectTranslationManager = $crowdSourcingProjectTranslationManager;
    }


    public function getUserDashboardViewModel($user): UserDashboardViewModel {
        $questionnaireIdsUserHasAnsweredTo = $this->questionnaireResponseRepository
            ->allWhere(['user_id' => $user->id])->pluck('questionnaire_id')->toArray();
        // should show only projects that are published and have at least 1 published questionnaire
        $questionnaires = $this->questionnaireRepository->getActiveQuestionnaires();

        foreach ($questionnaires as $questionnaire) {
            $questionnaire->goalVM = $this->crowdSourcingProjectGoalManager
                ->getQuestionnaireGoalViewModel($questionnaire, $questionnaire->responses_count);

            $nextUnlockableBadge = $this->questionnaireBadgeProvider
                ->getNextUnlockableBadgeToShowForQuestionnaire($questionnaire, $user->id, $questionnaireIdsUserHasAnsweredTo);
            $questionnaire->userHasAccessToViewStatisticsPage = $this->questionnaireAccessManager
                ->userHasAccessToViewQuestionnaireStatisticsPage($user, $questionnaire);
            $questionnaire->gamificationNextStepVM = new GamificationNextStep(
                $questionnaire->projects,
                $nextUnlockableBadge->getNextStepMessage(),
                $nextUnlockableBadge->imageFileName,
                true,
                new QuestionnaireSocialShareButtons($questionnaire->projects, $questionnaire, $user->id),
                in_array($questionnaire->id, $questionnaireIdsUserHasAnsweredTo));
        }
        $platformWideGamificationBadgesVM = $this->platformWideGamificationBadgesProvider->getPlatformWideGamificationBadgesListVM($user->id, $questionnaireIdsUserHasAnsweredTo);

        return new UserDashboardViewModel($questionnaires, $platformWideGamificationBadgesVM);
    }

}
