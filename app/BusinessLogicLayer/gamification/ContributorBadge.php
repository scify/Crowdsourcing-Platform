<?php

namespace App\BusinessLogicLayer\gamification;


class ContributorBadge extends GamificationBadge {


    public function __construct(int $allResponses, bool $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID;
        $this->color = '#3F51B5';
        parent::__construct("Contributor",
            "contributor.png",
            "Gain this badge, by answering to a questionnaire!",
            $allResponses, $userHasAchievedBadgePlatformWide);
    }

    protected function getBadgeMessageForLevel() {
        $word = $this->numberOfActionsPerformed == 1 ? 'questionnaire' : 'questionnaires';
        return 'You have answered ' . $this->numberOfActionsPerformed . ' ' . $word;
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge:';
        return 'You are a Level <b>' . $this->level . '</b> Contributor! Keep Going!';
    }

    public function getNextStepMessage() {
        if($this->userHasAchievedBadgePlatformWide)
            return 'Tell us what you think<br>and become a level <b>' . ($this->calculateLevel() + 1) . '</b> Contributor!';
        return 'Tell us what you think<br>and gain the "Contributor" badge! ';
    }
}
