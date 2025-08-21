<?php

declare(strict_types=1);

namespace App\Repository\Questionnaire\Statistics;

use App\Models\Questionnaire\Statistics\QuestionnaireBasicStatisticsColors;
use App\Repository\Repository;

class QuestionnaireBasicStatisticsColorsRepository extends Repository {
    public function getModelClassName(): string {
        return QuestionnaireBasicStatisticsColors::class;
    }
}
