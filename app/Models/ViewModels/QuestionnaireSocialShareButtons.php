<?php

namespace App\Models\ViewModels;


use App\Models\Questionnaire;

class QuestionnaireSocialShareButtons {

    public $questionnaire;
    public $referrerId;

    /**
     * QuestionnaireSocialShareButtons constructor.
     * @param $questionnaire Questionnaire the questionnaire to be shared
     * @param $referrerId int (optional) the id of the user that will share
     * the questionnaire
     */
    public function __construct($questionnaire, $referrerId = null) {
        $this->questionnaire = $questionnaire;
        $this->referrerId = $referrerId;
    }


}