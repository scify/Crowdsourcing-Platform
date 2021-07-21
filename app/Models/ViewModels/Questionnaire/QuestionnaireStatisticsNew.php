<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject;
use App\Models\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;

class QuestionnaireStatisticsNew {

    public $project;
    public $home_url;
    public $questionnaire;
    public $userCanPrintStatistics;

    public function __construct(Questionnaire $questionnaire,
                                CrowdSourcingProject $project,
                                $userCanPrintStatistics) {
        $this->questionnaire = $questionnaire;
        $this->project = $project;
        $this->home_url = route('project.landing-page', $project->slug);
        $this->userCanPrintStatistics = $userCanPrintStatistics;
    }

}
