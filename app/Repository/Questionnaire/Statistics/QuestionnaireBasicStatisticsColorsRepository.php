<?php

namespace App\Repository\Questionnaire\Statistics;

use App\Models\Questionnaire\Statistics\QuestionnaireBasicStatisticsColors;
use App\Repository\Repository;

class QuestionnaireBasicStatisticsColorsRepository extends Repository {
    public function getModelClassName() {
        return QuestionnaireBasicStatisticsColors::class;
    }
}
