<?php

namespace App\BusinessLogicLayer\gamification;


class CommunicatorBadge extends GamificationBadge {

    public function __construct(int $questionnairesSharedByUser, $userHasAchievedBadgePlatformWide) {
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $this->color = '#4CAF50';
        $numberOfActionsPerformed = $questionnairesSharedByUser;
        
        

        parent::__construct(__("badges_messages.communicator_title"),
            "communicator.png",
            __("badges_messages.gain_badge_by_inviting"),
            $numberOfActionsPerformed, $userHasAchievedBadgePlatformWide);
    }

    // protected function getBadgeMessageForLevel() {
    //     $message = __("badges_messages.clicks_on_shared_questionnaires") . $this->numberOfActionsPerformed . __("badges_messages.time");
    //     if($this->numberOfActionsPerformed > 1)
    //         $message .= 's';
    //     return $message;
    // }

    protected function getBadgeMessageForLevel() {
        $word = $this->numberOfActionsPerformed == 1 ? __("badges_messages.time") : __("badges_messages.times");
        return __("badges_messages.clicks_on_shared_questionnaires") . " <b>" . $this->numberOfActionsPerformed . '</b> ' . $word;
    }
    

    public function getEmailBody() {
        if($this->level == 1)
            return __("email_messages.unlocked_new_badge");
        return __("badges_messages.you_are_a_level") . " <b>" . $this->level . "</b> " . __("badges_messages.level_2_communicator");
    }

    public function getNextStepMessage() {
        if($this->userHasAchievedBadgePlatformWide)
            return __("badges_messages.become_level_2_communicator") . " <b>" . ($this->calculateLevel() + 1) . "</b> " . __("email_messages.communicator_title") . "!";
        return __("badges_messages.gain_communicator_badge");
    }
}
