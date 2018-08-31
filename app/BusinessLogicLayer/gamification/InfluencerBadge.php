<?php

namespace App\BusinessLogicLayer\gamification;


class InfluencerBadge extends GamificationBadge {

    public $numOfQuestionnaireReferralsForActiveQuestionnaire;
    public $percentageForActiveQuestionnaire;

    public function __construct(int $totalQuestionnaireReferrals, int $numOfQuestionnaireReferralsForActiveQuestionnaire, $percentageForActiveQuestionnaire) {
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->color = '#f44336';
        $this->numOfQuestionnaireReferralsForActiveQuestionnaire = $numOfQuestionnaireReferralsForActiveQuestionnaire;
        $this->percentageForActiveQuestionnaire = $percentageForActiveQuestionnaire;
        $numberOfActionsPerformed = $totalQuestionnaireReferrals;

        parent::__construct("Influencer",
            "influencer.png",
            "In order to gain this badge, people have to respond to your social posts and contribute!",
            $numberOfActionsPerformed);
    }

    public function getBadgeMessageForLevel() {
        return $this->numberOfActionsPerformed . ' people have anwered to questionnaires you shared';
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge:';
        return 'You are a Level <b>' . $this->level . '</b> Influencer! Keep Going!';
    }

    public function getNextStepMessage() {
        if(!$this->percentageForActiveQuestionnaire)
            $title = 'Zero people have responded to you call so far.<br>Write a compelling message and invite more friends!';
        else if($this->percentageForActiveQuestionnaire < 2)
            $title = 'Good job! ' . $this->numOfQuestionnaireReferralsForActiveQuestionnaire . ' have responded to your call so far.<br>Write a compelling message and invite more friends!';
        else
            $title = 'Wow, you are a true influencer!<br>' . $this->numOfQuestionnaireReferralsForActiveQuestionnaire . ' people have responded to your call so far. Write a compelling message and invite more friends!';
        return $title;
    }
}