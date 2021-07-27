<?php


namespace App\Models\ViewModels\Questionnaire;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponsesPerLanguage;
use App\Repository\Questionnaire\Statistics\QuestionnaireResponseStatistics;

class QuestionnaireStatistics {

    public $project;
    public $home_url;
    public $questionnaire;
    public $userCanPrintStatistics;
    public $questionnaireResponseStatistics;
    public $numberOfResponsesPerLanguage;

    public function __construct(Questionnaire $questionnaire,
                                CrowdSourcingProject $project,
                                QuestionnaireResponseStatistics $questionnaireResponseStatistics,
                                QuestionnaireResponsesPerLanguage $numberOfResponsesPerLanguage,
                                $userCanPrintStatistics) {
        $this->questionnaire = $questionnaire;
        $this->project = $project;
        $this->home_url = route('project.landing-page', $project->slug);
        $this->userCanPrintStatistics = $userCanPrintStatistics;
        $this->questionnaireResponseStatistics = $questionnaireResponseStatistics;
        $this->numberOfResponsesPerLanguage = $numberOfResponsesPerLanguage;
    }

}
