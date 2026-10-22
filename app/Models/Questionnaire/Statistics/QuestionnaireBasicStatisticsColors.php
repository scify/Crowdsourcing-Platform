<?php

declare(strict_types=1);

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class QuestionnaireStatisticsBasicColors
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $total_responses_color
 * @property string $goal_responses_color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereGoalResponsesColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereTotalResponsesColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireBasicStatisticsColors whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireBasicStatisticsColors extends Model {
    protected $table = 'questionnaire_basic_statistics_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'questionnaire_id', 'total_responses_color', 'goal_responses_color',
    ];
}
