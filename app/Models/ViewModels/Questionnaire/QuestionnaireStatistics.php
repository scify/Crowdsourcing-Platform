<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject;
use App\Models\Questionnaire;
use App\Repository\QuestionnaireStatistics\QuestionnaireResponsesPerLanguage;
use App\Repository\QuestionnaireStatistics\QuestionnaireResponseStatistics;

class QuestionnaireStatistics {

    public $project;
    public $home_url;
    public $questionnaireResponseStatistics;
    public $numberOfResponsesPerLanguage;
    public $questionnaire;

    public function __construct(Questionnaire $questionnaire,
                                CrowdSourcingProject $project,
                                QuestionnaireResponseStatistics $questionnaireResponseStatistics,
                                QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage) {
        $this->questionnaire = $questionnaire;
        $this->project = $project;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
        $this->home_url = route('project.landing-page', $project->slug);
    }

}
