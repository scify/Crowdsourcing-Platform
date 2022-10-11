<?php

namespace App\Repository\Questionnaire\Statistics;

use App\Models\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkp;
use App\Repository\Repository;

class QuestionnaireStatisticsPageVisibilityLkpRepository extends Repository {
    public function getModelClassName() {
        return QuestionnaireStatisticsPageVisibilityLkp::class;
    }
}
