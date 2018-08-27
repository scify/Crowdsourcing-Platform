<?php

namespace App\BusinessLogicLayer\gamification;

abstract class GamificationBadge {

    protected $pointsPerAction = 1;

    abstract public function getBadgeMessageForLevel(int $level);

    abstract public function getBadgeName();

    abstract public function getBadgeImageName();

    abstract public function getNumberOfActionsPerformed(int $userId);

    public function getLevel(int $userId) {
        return $this->getNumberOfActionsPerformed($userId) * $this->pointsPerAction;
    }
}