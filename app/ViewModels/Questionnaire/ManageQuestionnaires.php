<?php

declare(strict_types=1);

namespace App\ViewModels\Questionnaire;

use App\BusinessLogicLayer\lkp\QuestionnaireStatusLkp;

class ManageQuestionnaires {
    const STATUSES_CSS_CLASSES = [
        QuestionnaireStatusLkp::DRAFT => 'badge-warning',
        QuestionnaireStatusLkp::PUBLISHED => 'badge-success',
        QuestionnaireStatusLkp::FINALIZED => 'badge-primary',
        QuestionnaireStatusLkp::UNPUBLISHED => 'badge-danger',
        QuestionnaireStatusLkp::DELETED => 'badge-danger',
    ];

    public function __construct(public $questionnaires, public $statuses) {}

    public function setCssClassForStatus($status): string {
        return self::STATUSES_CSS_CLASSES[$status];
    }

    public function isQuestionnaireArchived($questionnaire): bool {
        if (! $questionnaire->created_at) {
            return false;
        }

        $dateCreated = date('Y/m/d', strtotime((string) $questionnaire->created_at));

        return $dateCreated < '2018/04/01';
    }
}
