<?php


namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\GamificationPointsCalculator;
use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionnaireResponseReferralRepository;
use App\Repository\UserQuestionnaireShareRepository;
use Illuminate\Support\Collection;

class PlatformWideGamificationBadgesProvider {

    protected $questionnaireRepository;
    protected $userQuestionnaireShareRepository;
    protected $questionnaireResponseReferralRepository;


    public function __construct(QuestionnaireRepository $questionnaireRepository,
                                UserQuestionnaireShareRepository $userQuestionnaireShareRepository,
                                QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
    }

    public function getPlatformWideGamificationBadgesListVM(int $userId): GamificationBadgesWithLevels {
        $badges = new Collection();
        $badges->push($this->getContributorBadge($userId));
        $badges->push($this->getCommunicatorBadge($userId));
        $badges->push($this->getInfluencerBadge($userId));

        $badgesVM = new Collection();
        foreach ($badges as $badge)
            $badgesVM->push(new GamificationBadgeVM($badge));
        $gamificationPointsCalculator = new GamificationPointsCalculator();

        return new GamificationBadgesWithLevels($badgesVM, $gamificationPointsCalculator->calculateTotalGamificationPoints($badges));
    }


    public function getContributorBadge($userId) {
        $allResponses = $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
        return new ContributorBadge($allResponses);
    }

    public function getCommunicatorBadge($userId) {
        return new CommunicatorBadge($this->userQuestionnaireShareRepository->getUserQuestionnaireSharesForUser($userId)->count(), $userId);
    }

    public function getInfluencerBadge($userId) {
        $numberOfActionsPerformedForQuestionnaire = null;
        $percentageForActiveQuestionnaire = null;
        $totalQuestionnaireReferrals = $this->questionnaireResponseReferralRepository->getQuestionnaireReferralsForUser($userId)->count();
        return new InfluencerBadge($totalQuestionnaireReferrals);
    }

}
