<?php

namespace App\Models\ViewModels\Questionnaire;

use Illuminate\Support\Facades\Auth;

class QuestionnaireModeratorAddResponse {
    public $project;
    public $questionnaire;
    public $languages;
    public $thankYouMode;
    public $userResponse;
    public $openQuestionnaireWhenPageLoads;
    public $feedbackQuestionnaire;
    public $moderator = true;

    public function __construct($project, $questionnaire, $languages) {
        $this->project = $project;
        $this->questionnaire = $questionnaire;
        $this->languages = $languages;
        $this->thankYouMode = false;
        $this->userResponse = null;
        $this->openQuestionnaireWhenPageLoads = true;
        $this->feedbackQuestionnaire = null;
    }

    public function shouldShowQuestionnaireStatisticsLink(): bool {
        return false;
    }

    public function getLoggedInUser() {
        return Auth::user();
    }
}
