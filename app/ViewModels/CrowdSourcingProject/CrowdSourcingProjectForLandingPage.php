<?php

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectForLandingPage extends CrowdSourcingProjectLayoutPage {
    public $questionnaire;
    public $feedbackQuestionnaire;
    public $projectHasPublishedProblems;
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
        CrowdSourcingProject $project,
        $questionnaire,
        $feedbackQuestionnaire,
        $projectHasPublishedProblems,
        $userResponse,
        $userFeedbackQuestionnaireResponse,
        $totalResponses,
        $questionnaireGoalVM,
        $socialMediaMetadataVM,
        Collection $languages,
        $shareUrlForFacebook,
        $shareUrlForTwitter) {
        parent::__construct($project);
        $this->questionnaire = $questionnaire;
        $this->feedbackQuestionnaire = $feedbackQuestionnaire;
        $this->projectHasPublishedProblems = $projectHasPublishedProblems;
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

    public function displayFeedbackQuestionnaire(): bool {
        // if user has responded to the main questionnaire,
        // and a feedback questionnaire exists
        // and the feedback questionnaire has not been answered
        return $this->userResponse != null &&
            $this->feedbackQuestionnaire != null
            && $this->userFeedbackQuestionnaireResponse == null;
    }
}
