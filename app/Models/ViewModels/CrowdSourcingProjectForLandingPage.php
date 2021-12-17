<?php

namespace App\Models\ViewModels;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CrowdSourcingProjectForLandingPage {
    public $project;
    public $questionnaire;
    public $feedbackQuestionnaire;
    public $userResponse;
    public $userFeedbackQuestionnaireResponse;
    public $allResponses;
    public $totalResponses;
    public $questionnaireGoalVM;
    public $socialMediaMetadataVM;
    public $languages;
    public $openQuestionnaireWhenPageLoads = false;

    public function __construct(
        $project,
        $questionnaire,
        $feedbackQuestionnaire,
        $userResponse,
        $userFeedbackQuestionnaireResponse,
        $allResponses,
        $questionnaireGoalVM,
        $socialMediaMetadataVM,
        Collection $languages,
        $openQuestionnaireWhenPageLoads)
    {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->feedbackQuestionnaire= $feedbackQuestionnaire;
        $this->userResponse = $userResponse;
        $this->userFeedbackQuestionnaireResponse = $userFeedbackQuestionnaireResponse;
        $this->allResponses = $allResponses;
        $this->totalResponses = $allResponses->count();
        $this->questionnaireGoalVM = $questionnaireGoalVM;
        $this->socialMediaMetadataVM = $socialMediaMetadataVM;
        $this->languages = $languages;
        $this->openQuestionnaireWhenPageLoads = $openQuestionnaireWhenPageLoads;
    }

    public function getSignInURLWithParameters(): string {
        $url = "/login?submitQuestionnaire=1&redirectTo=" . urlencode($this->project->slug . "?open=1");
        if (Request()->referrerId)
            $url .= urlencode("&referrerId=") . Request()->referrerId;
        if (Request()->questionnaireId)
            $url .= urlencode("&questionnaireId=") . Request()->questionnaireId;
        return $url;
    }


    public function displayFeedbackQuestionnaire():bool
    {
        // if user has responded to the main questionnaire,
        // and a feedback questionnaire exists
        // and the feedback questionnare has not been answered
        return $this->userResponse !=null &&
            $this->feedbackQuestionnaire !=null
            && $this->userFeedbackQuestionnaireResponse ==null;
    }

    public function shouldShowQuestionnaireStatisticsLink(): bool {
        return false;
    }

    public function getLoggedInUser() {
        return Auth::user();
    }
}
