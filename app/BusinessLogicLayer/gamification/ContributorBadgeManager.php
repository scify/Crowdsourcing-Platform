<?php

namespace App\BusinessLogicLayer\gamification;


use App\Repository\QuestionnaireRepository;

class ContributorBadgeManager extends GamificationBadge {
    
    private $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository, int $userId) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->badgeID = GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID;
        $this->numberOfActionsPerformed = $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
    }

    public function getBadgeMessageForLevel(int $level) {
        return 'You have answered ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->numberOfActionsPerformed;
    }

    public function getBadgeName() {
        return "Contributor";
    }

    public function getBadgeImageName() {
        return "contributor.png";
    }
}