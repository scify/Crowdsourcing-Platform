<?php

declare(strict_types=1);

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireStatisticsPageVisibilityLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class QuestionnaireStatisticsPageVisibilityLkp extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_statistics_page_visibility_lkp';
}
