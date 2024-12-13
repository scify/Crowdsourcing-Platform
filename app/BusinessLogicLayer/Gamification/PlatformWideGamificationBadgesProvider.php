<?php

namespace App\BusinessLogicLayer\Gamification;

use App\Repository\Questionnaire\QuestionnaireRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseReferralRepository;
use App\Repository\Questionnaire\Responses\QuestionnaireResponseRepository;
use App\Repository\Solution\SolutionRepository;
use App\Repository\Solution\SolutionUpvoteRepository;
use App\Repository\User\UserQuestionnaireShareRepository;
use App\ViewModels\Gamification\GamificationBadgesWithLevels;
use App\ViewModels\Gamification\GamificationBadgeVM;
use Illuminate\Support\Collection;

class PlatformWideGamificationBadgesProvider {
    protected QuestionnaireRepository $questionnaireRepository;
    protected UserQuestionnaireShareRepository $userQuestionnaireShareRepository;
    protected QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository;
    protected QuestionnaireResponseRepository $questionnaireResponseRepository;
    protected SolutionRepository $solutionRepository;
    protected SolutionUpvoteRepository $solutionUpvoteRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository,
        UserQuestionnaireShareRepository $userQuestionnaireShareRepository,
        QuestionnaireResponseReferralRepository $questionnaireResponseReferralRepository,
        QuestionnaireResponseRepository $questionnaireResponseRepository,
        SolutionRepository $solutionRepository,
        SolutionUpvoteRepository $solutionUpvoteRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->userQuestionnaireShareRepository = $userQuestionnaireShareRepository;
        $this->questionnaireResponseReferralRepository = $questionnaireResponseReferralRepository;
        $this->questionnaireResponseRepository = $questionnaireResponseRepository;
        $this->solutionRepository = $solutionRepository;
        $this->solutionUpvoteRepository = $solutionUpvoteRepository;
    }

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
        $numberOfUpvotesForSolutionsProposedByUser = $this->solutionUpvoteRepository
            ->getNumOfUpvotesForSolutionsProposedByUser($userId);

        $numberOfActionsPerformed = $numberOfShares + $numberOfUpvotesForSolutionsProposedByUser;

        return new CommunicatorBadge($numberOfActionsPerformed,
            $numberOfActionsPerformed > 0);
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
