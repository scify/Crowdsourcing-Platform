<?php

namespace App\BusinessLogicLayer\gamification;

use App\BusinessLogicLayer\UserQuestionnaireShareManager;

class CommunicatorBadge extends GamificationBadge {

    private $questionnaireShareManager;

    public function __construct(UserQuestionnaireShareManager $questionnaireShareManager, $userId) {
        $this->questionnaireShareManager = $questionnaireShareManager;
        $this->badgeID = GamificationBadgeIdsEnum::COMMUNICATOR_BADGE_ID;
        $this->color = '#4CAF50';
        $numberOfActionsPerformed = $this->questionnaireShareManager->getQuestionnairesSharedByUser($userId)->count();
        parent::__construct("Communicator",
            "communicator.png",
            "Gain this badge, by inviting more people to participate. Share to Facebook and Twitter!",
            $numberOfActionsPerformed, $userId);
    }

    protected function getBadgeMessageForLevel() {
        return 'You have shared ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getHTMLForCompletedAction() {
        return (object)[
            'badgeName' => 'Communicator (Level ' . $this->level . ')',
            'html' =>
                '<p>Thank you for inviting users to contribute!</p><p>The Communicator badge now belongs to you!</p>
                        <img class="gamification-badge" src="' . asset('images/badges/communicator.png') . '">
                        <p>Communicator <span class="level">(Level ' . $this->level . ')</span></p>'
        ];
    }

    public function getEmailBody() {
        // TODO: Implement getEmailBody() method.
    }
}