<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Gamification;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\Solution\SolutionRepository;
use App\Repository\Solution\SolutionShareRepository;
use App\Repository\Solution\SolutionUpvoteRepository;
use App\Repository\User\UserQuestionnaireShareRepository;
use App\ViewModels\Gamification\GamificationBadgesWithLevels;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Support\Collection;

class PlatformWideGamificationBadgesProvider {
    public function __construct(protected QuestionnaireRepository $questionnaireRepository, protected UserQuestionnaireShareRepository $userQuestionnaireShareRepository, protected QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository, protected QuestionnaireResponseRepository $questionnaireResponseRepository, protected SolutionRepository $solutionRepository, protected SolutionUpvoteRepository $solutionUpvoteRepository, protected SolutionShareRepository $solutionShareRepository) {}

    public function getPlatformWideGamificationBadgesListVM(int $userId, array $questionnaireIdsUserHasAnsweredTo): GamificationBadgesWithLevels {
        $badges = new Collection;
        $badges->push($this->getContributorBadge($userId, count($questionnaireIdsUserHasAnsweredTo)));
        $badges->push($this->getCommunicatorBadge($userId));
        $badges->push($this->getInfluencerBadge($userId));

        $badgesVM = new Collection;
        foreach ($badges as $badge) {
            $badgesVM->push(new GamificationBadgeVM($badge));
        }

        return new GamificationBadgesWithLevels($badgesVM);
    }

    public function getContributorBadge(int $userId, int $numberOfActionsPerformed): ContributorBadge {
        // we need to also get the number of solutions the user has proposed, and are published
        $numberOfSolutionsPublished = $this->solutionRepository->getPublishedSolutionsProposedByUser($userId)->count();
        $numberOfActionsPerformed += $numberOfSolutionsPublished;
        // we need to also get the number of solutions the user has upvoted
        $numberOfSolutionsUpvoted = $this->solutionUpvoteRepository->getUpvotesForUser($userId)->count();
        $numberOfActionsPerformed += $numberOfSolutionsUpvoted;

        return new ContributorBadge($numberOfActionsPerformed, $numberOfActionsPerformed > 0);
    }

    public function getCommunicatorBadge($userId): CommunicatorBadge {
        $numberOfShares = $this->userQuestionnaireShareRepository
            ->getUserQuestionnaireSharesForUser($userId)->count();

        $totalSolutionShares = $this->solutionShareRepository->getNumOfSharesForSolutionsProposedByUser($userId);

        $numberOfActionsPerformed = $numberOfShares + $totalSolutionShares;

        return new CommunicatorBadge($numberOfActionsPerformed,
            $numberOfActionsPerformed > 0);
    }

    public function getInfluencerBadge($userId): InfluencerBadge {
        $totalQuestionnaireReferrals = $this->questionnaireResponseReferralRepository->getQuestionnaireReferralsForUser($userId)->count();
        $numberOfUpvotesForSolutionsProposedByUser = $this->solutionUpvoteRepository
            ->getNumOfUpvotesForSolutionsProposedByUser($userId);

        $totalActionsPerformed = $totalQuestionnaireReferrals + $numberOfUpvotesForSolutionsProposedByUser;

        return new InfluencerBadge($totalActionsPerformed, $totalActionsPerformed > 0);
    }

    public function userHasAchievedCommunicatorBadge($userId): bool {
        if ($this->userQuestionnaireShareRepository->exists(['user_id' => $userId])) {
            return true;
        }

        return (bool) $this->solutionShareRepository->getNumOfSharesForSolutionsProposedByUser($userId);
    }

    public function userHasAchievedInfluencerBadge($userId): bool {
        if ($this->questionnaireResponseReferralRepository->exists(['referrer_id' => $userId])) {
            return true;
        }

        return $this->solutionUpvoteRepository->exists(['user_voter_id' => $userId]);
    }
}
