<?php

namespace App\BusinessLogicLayer\gamification;

class InfluencerBadge extends GamificationBadge {
    public int $questionnaireReferralsNum;

    public function __construct(int $questionnaireReferralsNum, $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->color = '#f44336';
        $this->questionnaireReferralsNum = $questionnaireReferralsNum;
        parent::__construct(
            __('badges_messages.influencer_title'),
            'influencer.png',
            __('badges_messages.gain_influencer_badge'),
            $questionnaireReferralsNum,
            $userHasAchievedBadgePlatformWide,
            15
        );
    }

    protected function getBadgeMessageForLevel(): string {
        return __('badges_messages.influencer_badge_points_explanation', ['points' => $this->pointsPerAction]);
    }

    public function getEmailBody(): string {
        if ($this->level == 1) {
            return __('email_messages.unlocked_new_badge');
        }

        return __('badges_messages.you_are_an_influencer', ['level' => "<b> $this->level </b>"]);
    }

    public function getNextStepMessage(): string {
        if (!$this->questionnaireReferralsNum) {
            $title = __('badges_messages.zero_people_responded_to_call');
        } elseif ($this->questionnaireReferralsNum < 2) {
            $title = __('badges_messages.good_job', $this->questionnaireReferralsNum, ['count' =>  $this->questionnaireReferralsNum]);
        } else {
            $title = __('badges_messages.true_influencer', $this->questionnaireReferralsNum, ['count' =>  $this->questionnaireReferralsNum]);
        }

        if ($this->userHasAchievedBadgePlatformWide) {
            $title .= __('badges_messages.become_an_influencer', ['level' => '<b> ' . ($this->calculateLevel() + 1) . ' </b>']);
        }

        return $title;
    }
}
