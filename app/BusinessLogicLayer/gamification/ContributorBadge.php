<?php

namespace App\BusinessLogicLayer\gamification;

class ContributorBadge extends GamificationBadge {
    public function __construct(int $allResponses, bool $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID;
        $this->color = '#3F51B5';
        parent::__construct(
            __('badges_messages.contributor_title'),
            'contributor.png',
            __('badges_messages.gain_badge_by_answering'),
            $allResponses,
            $userHasAchievedBadgePlatformWide
        );
    }

    protected function getBadgeMessageForLevel() {
        $word = $this->numberOfActionsPerformed == 1 ? __('badges_messages.questionnaire') : __('badges_messages.questionnaires');

        return __('badges_messages.you_have_answered', ['count' => "<b> $this->numberOfActionsPerformed </b>"]) . $word;
    }

    public function getEmailBody() {
        if ($this->level == 1) {
            return __('email_messages.unlocked_new_badge');
        }

        return __('badges_messages.you_are_a_contributor', ['level' => "<b> $this->level </b>"]);
    }

    // public function getNextStepMessage()
    // {
    //     if ($this->userHasAchievedBadgePlatformWide)
    //         return __("badges_messages.tell_us_what_you_think") . " <b>" . ($this->calculateLevel() + 1) . "</b> " . __("badges_messages.contributor_title") . "!";
    //     return __("badges_messages.gain_contributor_badge");
    // }

    public function getNextStepMessage() {
        if ($this->userHasAchievedBadgePlatformWide) {
            return __('badges_messages.become_a_contributor', ['level'=>'<b>' . ($this->calculateLevel() + 1) . '</b>']);
        }

        return __('badges_messages.gain_contributor_badge');
    }
}
