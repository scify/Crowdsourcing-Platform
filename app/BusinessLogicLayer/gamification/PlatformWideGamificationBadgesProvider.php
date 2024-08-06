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

    public function __construct(QuestionnaireRepository $questionnaireRepository,
        UserQuestionnaireShareRepository $userQuestionnaireShareRepository,
        QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository,
        QuestionnaireResponseRepository $questionnaireResponseRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
    }

    public function getPlatformWideGamificationBadgesListVM(int $userId, array $questionnaireIdsUserHasAnsweredTo): GamificationBadgesWithLevels {
        $badges = new Collection;
        $badges->push($this->getContributorBadge($questionnaireIdsUserHasAnsweredTo));
        $badges->push($this->getCommunicatorBadge($userId));
        $badges->push($this->getInfluencerBadge($userId));

        $badgesVM = new Collection;
        foreach ($badges as $badge) {
            $badgesVM->push(new GamificationBadgeVM($badge));
        }
        $gamificationPointsCalculator = new GamificationPointsCalculator;

        return new GamificationBadgesWithLevels($badgesVM, $gamificationPointsCalculator->calculateTotalGamificationPoints($badges));
    }

    public function getContributorBadge(array $questionnaireIdsUserHasAnsweredTo): ContributorBadge {
        return new ContributorBadge(count($questionnaireIdsUserHasAnsweredTo), count($questionnaireIdsUserHasAnsweredTo));
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

    public function userHasAchievedCommunicatorBadge($userId): bool {
        return $this->userQuestionnaireShareRepository->exists(['user_id' => $userId]);
    }

    public function userHasAchievedInfluencerBadge($userId): bool {
        return $this->questionnaireResponseReferralRepository->exists(['referrer_id' => $userId]);
    }
}
