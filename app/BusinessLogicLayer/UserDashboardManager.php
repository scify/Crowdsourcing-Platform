<?php


namespace App\BusinessLogicLayer;


use App\BusinessLogicLayer\gamification\PlatformWideGamificationBadgesProvider;
use App\BusinessLogicLayer\gamification\QuestionnaireBadgeProvider;
use App\Models\ViewModels\GamificationNextStep;
use App\Models\ViewModels\QuestionnaireSocialShareButtons;
use App\Models\ViewModels\UserDashboardViewModel;
use App\Repository\CrowdSourcingProjectRepository;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseRepository;

class UserDashboardManager {

    protected $projectRepository;
    protected $questionnaireRepository;
    protected $currentQuestionnaireCalculator;
    protected $platformWideGamificationBadgesProvider;
    protected $crowdSourcingProjectGoalManager;
    protected $questionnaireBadgeProvider;
    protected $questionnaireResponseRepository;

    public function __construct(CrowdSourcingProjectRepository $projectRepository,
                                QuestionnaireRepository $questionnaireRepository,
                                CurrentQuestionnaireProvider $currentQuestionnaireCalculator,
                                PlatformWideGamificationBadgesProvider $platformWideGamificationBadgesProvider,
                                QuestionnaireGoalManager $crowdSourcingProjectGoalManager,
                                QuestionnaireBadgeProvider $questionnaireBadgeProvider,
                                QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->projectRepository = $projectRepository;
        $this->questionnaireRepository = $questionnaireRepository;
        $this->currentQuestionnaireCalculator = $currentQuestionnaireCalculator;
        $this->platformWideGamificationBadgesProvider = $platformWideGamificationBadgesProvider;
        $this->crowdSourcingProjectGoalManager = $crowdSourcingProjectGoalManager;
        $this->questionnaireBadgeProvider = $questionnaireBadgeProvider;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }


    public function getUserDashboardViewModel(int $userId): UserDashboardViewModel {
        // should show only projects that are published and have at least 1 published questionnaire
        $projects = $this->projectRepository->getActiveProjectsWithAtLeastOneActiveQuestionnaire();

        foreach ($projects as $project) {
            // for each project, get the suitable questionnaire for the user
            $project->currentQuestionnaireForUser = $this->currentQuestionnaireCalculator->getCurrentQuestionnaire($project->id, $userId);
            $project->currentQuestionnaireGoalVM = $this->crowdSourcingProjectGoalManager->getQuestionnaireGoalViewModel($project->currentQuestionnaireForUser);
            $nextUnlockableBadgeForCurrentQuestionnaire = $this->questionnaireBadgeProvider
                ->getNextUnlockableBadgeToShowForQuestionnaire($project->currentQuestionnaireForUser, $userId);
            $project->gamificationNextStepVM = new GamificationNextStep(
                $project,
                $nextUnlockableBadgeForCurrentQuestionnaire->getNextStepMessage(),
                $nextUnlockableBadgeForCurrentQuestionnaire->imageFileName,
                true,
                new QuestionnaireSocialShareButtons($project, $project->currentQuestionnaireForUser, $userId),
                $this->questionnaireResponseRepository->questionnaireResponseExists($project->currentQuestionnaireForUser->id, $userId));
        }
        $platformWideGamificationBadgesVM = $this->platformWideGamificationBadgesProvider->getPlatformWideGamificationBadgesListVM($userId);

        return new UserDashboardViewModel($projects, $platformWideGamificationBadgesVM);
    }

}
