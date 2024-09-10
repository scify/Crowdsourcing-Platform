<?php

namespace App\ViewModels\CrowdSourcingProject;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CrowdSourcingProjectForLandingPage {
    public $project;
    public $questionnaire;
    public $feedbackQuestionnaire;
    public $userResponse;
    public $userFeedbackQuestionnaireResponse;
    public $totalResponses;
    public $questionnaireGoalVM;
    public $socialMediaMetadataVM;
    public $languages;
    public $shareUrlForFacebook;
    public $shareUrlForTwitter;
    public $thankYouMode;
    public $moderator;

    public function __construct(
        $project,
        $questionnaire,
        $feedbackQuestionnaire,
        $userResponse,
        $userFeedbackQuestionnaireResponse,
        $totalResponses,
        $questionnaireGoalVM,
        $socialMediaMetadataVM,
        Collection $languages,
        $shareUrlForFacebook,
        $shareUrlForTwitter) {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->feedbackQuestionnaire = $feedbackQuestionnaire;
        $this->userResponse = $userResponse;
        $this->userFeedbackQuestionnaireResponse = $userFeedbackQuestionnaireResponse;
        $this->totalResponses = $totalResponses;
        $this->questionnaireGoalVM = $questionnaireGoalVM;
        $this->socialMediaMetadataVM = $socialMediaMetadataVM;
        $this->languages = $languages;
        $this->shareUrlForFacebook = $shareUrlForFacebook;
        $this->shareUrlForTwitter = $shareUrlForTwitter;
        $this->thankYouMode = false;
        $this->moderator = false;
    }

    public function getSignInURLWithParameters(): string {
        $url = '/login?submitQuestionnaire=1&redirectTo=' . urlencode($this->project->slug . '?open=1');
        if (Request()->referrerId) {
            $url .= urlencode('&referrerId=') . Request()->referrerId;
        }
        if (Request()->questionnaireId) {
            $url .= urlencode('&questionnaireId=') . Request()->questionnaireId;
        }

        return $url;
    }

    public function displayFeedbackQuestionnaire(): bool {
        // if user has responded to the main questionnaire,
        // and a feedback questionnaire exists
        // and the feedback questionnare has not been answered
        return $this->userResponse != null &&
            $this->feedbackQuestionnaire != null
            && $this->userFeedbackQuestionnaireResponse == null;
    }

    public function shouldShowQuestionnaireStatisticsLink(): bool {
        return true;
    }

    public function getLoggedInUser() {
        return Auth::user();
    }
}
