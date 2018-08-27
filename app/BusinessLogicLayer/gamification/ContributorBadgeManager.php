<?php

namespace App\BusinessLogicLayer\gamification;


use App\Repository\QuestionnaireRepository;

class ContributorBadgeManager extends GamificationBadge {

    const INFLUENCER_LOW_LEVEL = 0;
    const INFLUENCER_MID_LEVEL = 5;
    const INFLUENCER_HIGH_LEVEL = 10;
    
    private $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository) {
        $this->questionnaireRepository = $questionnaireRepository;
    }

    public function getBadgeMessageForLevel(int $level) {
        switch ($level) {
            case $level == self::INFLUENCER_LOW_LEVEL:
                return "You are in lower level";
            case $level <= self::INFLUENCER_MID_LEVEL:
                return "You are in mid level";
            case $level <= self::INFLUENCER_HIGH_LEVEL:
                return "You are in high level";
            case $level > self::INFLUENCER_HIGH_LEVEL:
                return "You are in highest level";
            default:
                throw new \Exception("Unsupported gamification level: " . $level);
        }
    }

    public function getNumberOfActionsPerformed(int $userId) {
        return $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count();
    }

    public function getBadgeName() {
        return "Contributor";
    }

    public function getBadgeImageName() {
        return "contributor.png";
    }
}