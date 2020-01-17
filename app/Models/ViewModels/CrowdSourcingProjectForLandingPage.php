<?php

namespace App\Models\ViewModels;


class CrowdSourcingProjectForLandingPage
{
    public $project;
    public $questionnaire;
    public $userResponse;
    public $allResponses;
    public $allLanguagesForQuestionnaire;
    public $totalResponses;
    public $openQuestionnaireWhenPageLoads = false;
    public $questionnaireGoalVM;
    public $socialMediaMetadataVM;

    public function __construct($project, $questionnaire,
                                $userResponse,
                                $allResponses,
                                $allLanguagesForQuestionnaire,
                                $openQuestionnaireWhenPageLoads,
                                $questionnaireGoalVM,
                                $socialMediaMetadataVM)
    {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->userResponse = $userResponse;
        $this->allResponses = $allResponses;
        $this->allLanguagesForQuestionnaire = $allLanguagesForQuestionnaire;
        $this->totalResponses = $allResponses->count();
        $this->questionnaireGoalVM = $questionnaireGoalVM;
        $this->openQuestionnaireWhenPageLoads = $openQuestionnaireWhenPageLoads;
        $this->socialMediaMetadataVM = $socialMediaMetadataVM;
    }
}
