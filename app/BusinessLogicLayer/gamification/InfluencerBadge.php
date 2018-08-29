<?php

namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;

class InfluencerBadge extends GamificationBadge {

    private $questionnaireResponseReferralManager;

    public function __construct(QuestionnaireResponseReferralManager $questionnaireResponseReferralManager, int $userId) {
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $pointsPerAction = 5;
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $numberOfActionsPerformed = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
        parent::__construct("Influencer",
            "influencer.png",
            "When someone clicks on your shared questionnaire and answers, you will get this badge",
            $numberOfActionsPerformed, $userId, $pointsPerAction);
    }

    public function getBadgeMessageForLevel() {
        return 'You have invited ' . $this->numberOfActionsPerformed . ' people to answer';
    }
}