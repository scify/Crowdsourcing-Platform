<?php

declare(strict_types=1);

namespace App\BusinessLogicLayer\Gamification;

abstract class GamificationBadge {
    public string $badgeID;

    public int $level = 0;

    public string $messageForLevel;

    public string $statusMessage;

    public string $color;

    public function __construct(public string $name, public string $imageFileName, $requiredActionMessage,
        public int $numberOfActionsPerformed, protected bool $userHasAchievedBadgePlatformWide, protected int $pointsPerAction, public string $progressMessage = '', public int $finalLevel = 0) {
        $this->level = $this->calculateLevel();
        $this->messageForLevel = $this->getBadgeMessageForLevel();
        $this->statusMessage = $this->calculateStatusMessage($requiredActionMessage);
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
