<?php

namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;

class PersuaderBadge extends GamificationBadge {

    private $questionnaireResponseReferralManager;

    public function __construct(QuestionnaireResponseReferralManager $questionnaireResponseReferralManager, int $userId) {
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $pointsPerAction = 5;
        $this->badgeID = GamificationBadgeIdsEnum::PERSUADER_BADGE_ID;
        $numberOfActionsPerformed = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
        parent::__construct("Influencer",
            "persuader.png",
            "You will gain this badge once people respond to projects you have shared!",
            $numberOfActionsPerformed, $userId, $pointsPerAction);
    }

    public function getBadgeMessageForLevel() {
        return 'You have invited ' . $this->numberOfActionsPerformed . ' people to answer';
    }
}