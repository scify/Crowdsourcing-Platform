<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Statistics;

use App\Models\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkp;
use App\Repository\Repository;

class QuestionnaireStatisticsPageVisibilityLkpRepository extends Repository {
    public function getModelClassName(): string {
        return QuestionnaireStatisticsPageVisibilityLkp::class;
    }
}
