<?php


namespace App\Repository\Questionnaire\Statistics;


use App\Models\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkp;
use App\Repository\Repository;

class QuestionnaireStatisticsPageVisibilityLkpRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireStatisticsPageVisibilityLkp::class;
    }
}
