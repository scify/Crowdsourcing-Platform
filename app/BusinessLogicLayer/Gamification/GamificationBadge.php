<?php

namespace App\BusinessLogicLayer\Gamification;

abstract class GamificationBadge {
    protected int $pointsPerAction = 1;
    public string $badgeID;
    public int $numberOfActionsPerformed = -1;
    public int $level = 0;
    public string $name;
    public string $messageForLevel;
    public string $imageFileName;
    public string $statusMessage;
    public string $color;
    public string $progressMessage;
    public int $finalLevel;
    protected bool $userHasAchievedBadgePlatformWide;

    public function __construct($name, $imageFileName, $requiredActionMessage,
        $numberOfActionsPerformed, $userHasAchievedBadgePlatformWide, $pointsPerAction, $progressMessage = '', $finalLevel = 0) {
        $this->name = $name;
        $this->imageFileName = $imageFileName;
        $this->numberOfActionsPerformed = $numberOfActionsPerformed;
        $this->pointsPerAction = $pointsPerAction;
        $this->level = $this->calculateLevel();
        $this->messageForLevel = $this->getBadgeMessageForLevel();
        $this->statusMessage = $this->calculateStatusMessage($requiredActionMessage);
        $this->userHasAchievedBadgePlatformWide = $userHasAchievedBadgePlatformWide;
        $this->progressMessage = $progressMessage;
        $this->finalLevel = $finalLevel;
    }

    abstract protected function getBadgeMessageForLevel();

    abstract public function getEmailBody();

    protected function calculateLevel(): int {
        return $this->numberOfActionsPerformed * $this->pointsPerAction;
    }

    private function calculateStatusMessage($requiredActionMessage) {
        if ($this->level == 0) {
            return $requiredActionMessage;
        }

        return __('badges_messages.you_have_the') . $this->name . __('badges_messages.badge');
    }
}
