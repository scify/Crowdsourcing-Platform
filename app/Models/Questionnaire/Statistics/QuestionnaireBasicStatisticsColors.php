<?php

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireStatisticsBasicColors
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $total_responses_color
 * @property string $goal_responses_color
 */
class QuestionnaireBasicStatisticsColors extends Model {
    protected $table = 'questionnaire_basic_statistics_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionnaire_id', 'total_responses_color', 'goal_responses_color',
    ];
}
