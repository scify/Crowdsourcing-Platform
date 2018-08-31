<?php

namespace App\BusinessLogicLayer\gamification;


use App\BusinessLogicLayer\QuestionnaireResponseReferralManager;

class InfluencerBadge extends GamificationBadge {

    private $questionnaireResponseReferralManager;
    public $numberOfActionsPerformedForQuestionnaire;
    public $percentageForActiveQuestionnaire;

    public function __construct(QuestionnaireResponseReferralManager $questionnaireResponseReferralManager, int $userId, $activeQuestionnaire) {
        $this->questionnaireResponseReferralManager = $questionnaireResponseReferralManager;
        $this->pointsPerAction = 5;
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->color = '#f44336';
        $numberOfActionsPerformed = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUser($userId)->count();
        if($activeQuestionnaire) {
            $this->numberOfActionsPerformedForQuestionnaire = $this->questionnaireResponseReferralManager->getQuestionnaireReferralsForUserForQuestionnaire($activeQuestionnaire->id, $userId)->count();
            $this->percentageForActiveQuestionnaire =  ($this->numberOfActionsPerformedForQuestionnaire / $activeQuestionnaire->goal) * 100;
        }
        parent::__construct("Influencer",
            "influencer.png",
            "In order to gain this badge, people have to respond to your social posts and contribute!",
            $numberOfActionsPerformed, $userId);
    }

    public function getBadgeMessageForLevel() {
        return $this->numberOfActionsPerformed . ' people have anwered to questionnaires you shared';
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge:';
        return 'You are a Level <b>' . $this->level . '</b> Influencer! Keep Going!';
    }
}