<?php

namespace App\Models\ViewModels;


use App\Models\Questionnaire\Questionnaire;

class QuestionnaireSocialShareButtons {

    public $questionnaire;
    public $project;
    public $referrerId;

    /**
     * QuestionnaireSocialShareButtons constructor.
     * @param $project \App\Models\CrowdSourcingProject the project the questionnaire belongs to
     * @param $questionnaire Questionnaire the questionnaire to be shared
     * @param $referrerId int (optional) the id of the user that will share
     * the questionnaire
     */
    public function __construct($project, $questionnaire, $referrerId = null) {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->referrerId = $referrerId;
    }

    public function getSocialShareURL() {
        return url('/' . $this->project->slug) . urlencode('?open=1&referrerId=' . $this->referrerId . '&questionnaireId=' . $this->questionnaire->id);
    }

}
