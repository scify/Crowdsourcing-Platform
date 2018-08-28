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

    public function __construct($name, $imageFileName, $numberOfActionsPerformed, $pointsPerAction = 1) {
        $this->name = $name;
        $this->imageFileName = $imageFileName;
        $this->numberOfActionsPerformed = $numberOfActionsPerformed;
        $this->pointsPerAction = $pointsPerAction;
        $this->level = $this->calculateLevel();
        $this->messageForLevel = $this->getBadgeMessageForLevel();
    }

    abstract protected function getBadgeMessageForLevel();

    protected function calculateLevel() {
        return $this->numberOfActionsPerformed * $this->pointsPerAction;
    }
}