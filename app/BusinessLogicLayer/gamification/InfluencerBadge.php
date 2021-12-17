<?php

namespace App\BusinessLogicLayer\gamification;


class InfluencerBadge extends GamificationBadge
{

    public $questionnaireReferralsNum;

    public function __construct(int $questionnaireReferralsNum, $userHasAchievedBadgePlatformWide)
    {
        $this->badgeID = GamificationBadgeIdsEnum::INFLUENCER_BADGE_ID;
        $this->color = '#f44336';
        $this->questionnaireReferralsNum = $questionnaireReferralsNum;
        parent::__construct(
            __("badges_messages.influencer_title"),
            "influencer.png",
            __("badges_messages.gain_influencer_badge"),
            $questionnaireReferralsNum,
            $userHasAchievedBadgePlatformWide
        );
    }

    public function getBadgeMessageForLevel()
    {
        $word = $this->numberOfActionsPerformed == 1 ? __("badges_messages.person") : __("badges_messages.people");
        return $this->numberOfActionsPerformed . ' ' . $word .  __("badges_messages.responded_to_call");
    }



    public function getEmailBody()
    {
        if ($this->level == 1)
            return __("email_messages.unlocked_new_badge");
        return __("badges_messages.you_are_an_influencer", ["level" => "<b> $this->level </b>"]);
    }

    public function getNextStepMessage()
    {
        if (!$this->questionnaireReferralsNum)
            $title = __("badges_messages.zero_people_responded_to_call");
        else if ($this->questionnaireReferralsNum < 2) {
            $peopleStr = $this->questionnaireReferralsNum == 1 ? __("badges_messages.person_has_responded") : __("badges_messages.people_have_responded");
            $title = __("badges_messages.good_job") . $this->questionnaireReferralsNum . $peopleStr . __("badges_messages.people_responded_to_call");
        } else {
            $peopleStr = $this->questionnaireReferralsNum == 1 ? __("badges_messages.person_has_responded") : __("badges_messages.people_have_responded");
            $title = __("badges_messages.true_influencer") . $this->questionnaireReferralsNum . $peopleStr . __("badges_messages.people_responded_to_call_2");
        }

        //     if ($this->userHasAchievedBadgePlatformWide)
        //         $title .= __("badges_messages.you_are_close") . " <b>" . ($this->calculateLevel() + 1) . "</b> " . __("badges_messages.influencer_title") . "!";
        //     return $title;
        // }

        if ($this->userHasAchievedBadgePlatformWide)
            $title .= __("badges_messages.become_an_influencer", ["level" => "<b> $this->calculateLevel() + 1 </b>"]);
        return $title;
    }
}
