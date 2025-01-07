<?php

namespace App\ViewModels\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatisticsPageVisibilityLkp;
use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Questionnaire\Questionnaire;
use App\Models\Questionnaire\QuestionnaireResponse;
use App\Models\User\User;
use App\ViewModels\CrowdSourcingProject\CrowdSourcingProjectLayoutPage;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class QuestionnairePage extends CrowdSourcingProjectLayoutPage {
    public CrowdSourcingProject $project;

    public function __construct(public Questionnaire $questionnaire, public ?QuestionnaireResponse $userResponse, CrowdSourcingProject $project, public Collection $languages, public bool $moderator) {
        parent::__construct($project);
    }

    public function shouldShowQuestionnaireStatisticsLink(): bool {
        return $this->questionnaire->statistics_page_visibility_lkp_id === QuestionnaireStatisticsPageVisibilityLkp::PUBLIC;
    }

    public function getLoggedInUser(): User|Authenticatable|null {
        return Auth::user();
    }

    public function getLocale(): string {
        return app()->getLocale();
    }

    public function shouldShowQuestionnaireDescription(): bool {
        return $this->questionnaire->fieldsTranslation->description && $this->questionnaire->fieldsTranslation->description !== $this->questionnaire->fieldsTranslation->title;
    }
}
