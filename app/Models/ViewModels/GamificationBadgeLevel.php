<?php

namespace App\Models\ViewModels;


class GamificationBadgeLevel {

    public $badgeImageName;
    public $badgeName;
    public $level;
    public $badgeMessage;

    public function __construct($badgeName, $level, $badgeMessage, $badgeImageName) {
        $this->badgeName = $badgeName;
        $this->level = $level;
        $this->badgeMessage = $badgeMessage;
        $this->badgeImageName = $badgeImageName;
    }


}