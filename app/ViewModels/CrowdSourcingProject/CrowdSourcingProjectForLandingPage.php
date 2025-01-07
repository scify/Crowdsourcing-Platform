<?php

namespace App\ViewModels\CrowdSourcingProject;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use Illuminate\Support\Collection;

class CrowdSourcingProjectForLandingPage extends CrowdSourcingProjectLayoutPage {
    /**
     * @var \Illuminate\Support\Collection
     */
    public $languages;

    public $thankYouMode = false;
    public $moderator = false;

    public function __construct(
        CrowdSourcingProject $project,
        public $questionnaire,
        public $feedbackQuestionnaire,
        public $projectHasPublishedProblems,
        public $userResponse,
        public $userFeedbackQuestionnaireResponse,
        public $totalResponses,
        public $questionnaireGoalVM,
        public $socialMediaMetadataVM,
        Collection $languages,
        public $shareUrlForFacebook,
        public $shareUrlForTwitter) {
        parent::__construct($project);
        $this->languages = $languages;
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
