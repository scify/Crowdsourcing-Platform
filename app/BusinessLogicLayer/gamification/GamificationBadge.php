<?php

namespace App\BusinessLogicLayer\gamification;

abstract class GamificationBadge {

    protected $pointsPerAction = 1;
    public $badgeID;
    public $numberOfActionsPerformed = -1;
    public $level = 0;
    public $name;
    public $messageForLevel;
    public $imageFileName;
    public $statusMessage;
    public $color;
    protected $userHasAchievedBadgePlatformWide;

    public function __construct($name, $imageFileName, $requiredActionMessage,
                                $numberOfActionsPerformed, $userHasAchievedBadgePlatformWide, $pointsPerAction = 1) {
        $this->name = $name;
        $this->imageFileName = $imageFileName;
        $this->numberOfActionsPerformed = $numberOfActionsPerformed;
        $this->pointsPerAction = $pointsPerAction;
        $this->level = $this->calculateLevel();
        $this->messageForLevel = $this->getBadgeMessageForLevel();
        $this->statusMessage = $this->calculateStatusMessage($requiredActionMessage);
        $this->userHasAchievedBadgePlatformWide = $userHasAchievedBadgePlatformWide;
    }

    abstract protected function getBadgeMessageForLevel();

    abstract public function getEmailBody();

    protected function calculateLevel() {
        return $this->numberOfActionsPerformed * $this->pointsPerAction;
    }

    private function calculateStatusMessage($requiredActionMessage) {
        if($this->level == 0)
            return $requiredActionMessage;
        return 'You have the ' . $this->name . ' badge!';
    }
}
