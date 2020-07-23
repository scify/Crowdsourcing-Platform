<?php


namespace App\Repository\Questionnaire\Statistics;


use App\Models\QuestionnaireStatisticsPageVisibilityLkp;
use App\Repository\Repository;

class QuestionnaireStatisticsPageVisibilityLkpRepository extends Repository {

    function getModelClassName() {
        return QuestionnaireStatisticsPageVisibilityLkp::class;
    }
}
