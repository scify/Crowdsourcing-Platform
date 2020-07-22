<?php

namespace App\Models\Questionnaire\Statistics;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionnaireLanguageStatisticsColor
 * @package App\Models\Questionnaire\Statistics
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $language_id
 * @property string $color
 */
class QuestionnaireLanguageStatisticsColor extends Model
{
    protected $table = 'questionnaire_language_statistics_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionnaire_id', 'language_id', 'color'
    ];
}
