<?php

namespace App\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;

class QuestionnaireSocialShareButtons {
    public $questionnaire;
    public $referrerId;

    /**
     * QuestionnaireSocialShareButtons constructor.
     *
     * @param $questionnaire Questionnaire the questionnaire to be shared
     * @param $referrerId int (optional) the id of the user that will share
     * the questionnaire
     */
    public function __construct(Questionnaire $questionnaire, $referrerId = null) {
        $this->questionnaire = $questionnaire;
        $this->referrerId = $referrerId;
    }

    public function getSocialShareURL(CrowdSourcingProject $project, $medium) {
        switch ($medium) {
            case 'facebook':
                $url = 'https://www.facebook.com/sharer/sharer.php?u=';
                break;
            case 'twitter':
                $url = 'https://x.com/share?url=';
                break;
            default:
                $url = '';
                break;
        }

        return $url . route('project.landing-page', $project->slug) . urlencode('?open=1&referrerId=' . $this->referrerId . '&questionnaireId=' . $this->questionnaire->id);
    }
}
