<?php

namespace App\BusinessLogicLayer\gamification;


use App\Repository\QuestionnaireRepository;

class ContributorBadge extends GamificationBadge {
    
    private $questionnaireRepository;

    public function __construct(QuestionnaireRepository $questionnaireRepository, int $userId) {
        $this->questionnaireRepository = $questionnaireRepository;
        $this->badgeID = GamificationBadgeIdsEnum::CONTRUBUTOR_BADGE_ID;
        parent::__construct("Contributor",
            "contributor.png",
            "Gain this badge, by answering to a questionnaire!",
            $this->questionnaireRepository->getAllResponsesGivenByUser($userId)->count());
    }

    protected function getBadgeMessageForLevel() {
        return 'You have answered ' . $this->numberOfActionsPerformed . ' questionnaires';
    }

    public function getHTMLForCompletedAction() {
        return (object)[
            'badgeName' => 'Contributor (Level ' . $this->level . ')',
            'html' =>
                '<p>Thank you for your contribution!</p><p>' . $this->getCompletedActionTitle() .'</p>
                        <img class="gamification-badge" src="' . asset('images/badges/contributor.png') . '">
                        <p>Contributor <span class="level">(Level ' . $this->level . ')</span></p>'
            ];
    }

    private function getCompletedActionTitle() {
        if($this->level == 1)
            return 'The Contributor Badge now belongs to you!';
        return 'You are a Level <b>' . $this->level . '</b> Contributor! Keep Going!';
    }

    public function getEmailBody() {
        if($this->level == 1)
            return 'You have also unlocked a new badge: 
                    <br><br><div style="width: 100%; text-align: center">
                    <b style="text-align: center; font-size: 25px; margin-bottom: 30px;">' . $this->name . '</b><br><br><br>
                    <img style="height:150px" src="' . asset('images/badges/contributor.png') . '">
                    <br>
                    <p style="margin-top: 30px; font-size: 18px;">Impressive!</p><br>
                    </div>
                    '
                ;
        return 'You are a Level <b>' . $this->level . '</b> Contributor! Keep Going!';
    }
}