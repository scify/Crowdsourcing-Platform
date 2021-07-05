<?php

namespace App\Models\ViewModels;


use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use Illuminate\Support\Collection;

class CrowdSourcingProjectForLandingPage
{
    public $project;
    public $questionnaire;
    public $userResponse;
    public $allResponses;
    public $totalResponses;
    public $openQuestionnaireWhenPageLoads = false;
    public $questionnaireGoalVM;
    public $socialMediaMetadataVM;
    public $languages;

    public function __construct($project, $questionnaire,
                                $userResponse,
                                $allResponses,
                                $openQuestionnaireWhenPageLoads,
                                $questionnaireGoalVM,
                                $socialMediaMetadataVM,
                                Collection $languages)
    {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->userResponse = $userResponse;
        $this->allResponses = $allResponses;
        $this->totalResponses = $allResponses->count();
        $this->questionnaireGoalVM = $questionnaireGoalVM;
        $this->openQuestionnaireWhenPageLoads = $openQuestionnaireWhenPageLoads;
        $this->socialMediaMetadataVM = $socialMediaMetadataVM;
        $this->languages = $languages;
    }

    public function getSignInURLWithParameters() {
        $url = "/login?submitQuestionnaire=1&redirectTo=" . urlencode($this->project->slug."?open=1");
        if(Request()->referrerId)
            $url .= urlencode("&referrerId=") . Request()->referrerId;
        if(Request()->questionnaireId)
            $url .= urlencode("&questionnaireId=") . Request()->questionnaireId;
        return $url;
    }

    public function shouldShowQuestionnaireStatisticsLink(): bool {
        return $this->questionnaire->statistics_page_visibility_lkp_id === QuestionnaireStatisticsPageVisibilityLkp::PUBLIC;
    }
}
