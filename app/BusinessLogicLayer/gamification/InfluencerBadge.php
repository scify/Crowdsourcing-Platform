<?php

namespace App\BusinessLogicLayer\gamification;


class InfluencerBadge extends GamificationBadge {

    public $questionnaireReferralsNum;

    public function __construct(int $questionnaireReferralsNum) {
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->color = '#f44336';
        $this->questionnaireReferralsNum = $questionnaireReferralsNum;

        parent::__construct("Influencer",
            "influencer.png",
            "In order to gain this badge, people have to respond to your social posts and contribute!",
            $questionnaireReferralsNum);
    }

    public function getBadgeMessageForLevel() {
        $word = $this->numberOfActionsPerformed == 1 ? 'person' : 'people';
        return $this->numberOfActionsPerformed . ' ' . $word .  ' responded to your call';
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge:';
        return 'You are a Level <b>' . $this->level . '</b> Influencer! Keep Going!';
    }

    public function getNextStepMessage() {
        if(!$this->questionnaireReferralsNum)
            $title = 'Zero people have responded to your call so far.<br>Write a compelling message and invite more friends!';
        else if($this->questionnaireReferralsNum < 2) {
            $peopleStr = $this->questionnaireReferralsNum == 1 ? ' person has responded ' : ' people have responded ';
            $title = 'Good job! ' . $this->questionnaireReferralsNum . $peopleStr . ' to your call so far.<br>Write a compelling message and invite more friends!';
        }
        else {
            $peopleStr = $this->questionnaireReferralsNum == 1 ? ' person has responded ' : ' people have responded ';
            $title = 'Wow, you are a true influencer!<br>' . $this->questionnaireReferralsNum . $peopleStr . ' to your call so far. Write a compelling message and invite more friends!';
        }

        return $title;
    }
}
