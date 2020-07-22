<?php

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireQuestionStatisticsColor
 * @package App\Models\Questionnaire\Statistics
 *
 * @property int $id
 * @property int $questionnaire_question_id
 * @property int $language_id
 * @property string $color
 */
class QuestionnaireQuestionStatisticsColor extends Model
{
    protected $table = 'questionnaire_question_statistics_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionnaire_question_id', 'language_id', 'color'
    ];
}
