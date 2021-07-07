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
    public $questionnaireGoalVM;
    public $socialMediaMetadataVM;
    public $languages;

    public function __construct($project, $questionnaire,
                                $userResponse,
                                $allResponses,
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
        $this->socialMediaMetadataVM = $socialMediaMetadataVM;
        $this->languages = $languages;
    }

    public function getSignInURLWithParameters(): string {
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
