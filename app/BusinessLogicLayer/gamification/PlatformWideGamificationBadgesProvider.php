<?php


namespace App\BusinessLogicLayer\gamification;


use App\Models\ViewModels\GamificationBadgesWithLevels;
use App\Models\ViewModels\GamificationBadgeVM;
use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\UserQuestionnaireShareRepository;
use Illuminate\Support\Collection;

class PlatformWideGamificationBadgesProvider {

    protected $questionnaireRepository;
    protected $userQuestionnaireShareRepository;
    protected $questionnaireResponseReferralRepository;
    protected $questionnaireResponseRepository;


    public function __construct(QuestionnaireRepository                 $questionnaireRepository,
                                UserQuestionnaireShareRepository        $userQuestionnaireShareRepository,
                                QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository,
                                QuestionnaireResponseRepository         $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
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


    public function getContributorBadge($userId): ContributorBadge {
        $allResponses = $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
        return new ContributorBadge($allResponses, $this->userHasAchievedContributorBadge($userId));
    }

    public function getCommunicatorBadge($userId): CommunicatorBadge {
        return new CommunicatorBadge($this->userQuestionnaireShareRepository
            ->getUserQuestionnaireSharesForUser($userId)->count(),
            $this->userHasAchievedCommunicatorBadge($userId));
    }

    public function getInfluencerBadge($userId): InfluencerBadge {
        $totalQuestionnaireReferrals = $this->questionnaireResponseReferralRepository->getQuestionnaireReferralsForUser($userId)->count();
        return new InfluencerBadge($totalQuestionnaireReferrals, $this->userHasAchievedInfluencerBadge($userId));
    }

    public function userHasAchievedContributorBadge($userId): bool {
        return $this->questionnaireResponseRepository->exists(['user_id' => $userId]);
    }

    public function userHasAchievedCommunicatorBadge($userId): bool {
        return $this->userQuestionnaireShareRepository->exists(['user_id' => $userId]);
    }

    public function userHasAchievedInfluencerBadge($userId): bool {
        return $this->questionnaireResponseReferralRepository->exists(['referrer_id' => $userId]);
    }

}
