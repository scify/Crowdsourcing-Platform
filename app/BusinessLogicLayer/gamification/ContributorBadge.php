<?php

namespace App\BusinessLogicLayer\gamification;


use App\Repository\QuestionnaireRepository;

class ContributorBadge extends GamificationBadge {
    
    private $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository, int $userId) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->badgeID = GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID;
        parent::__construct("Contributor","contributor.png", $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count());
    }

    protected function getBadgeMessageForLevel() {
        return 'You have answered ' . $this->numberOfActionsPerformed . ' questionnaires';
    }
}