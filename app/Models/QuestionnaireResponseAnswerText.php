<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponseAnswerText
 *
 * @property int $id
 * @property int $questionnaire_response_answer_id
 * @property string $answer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswerText onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereQuestionnaireResponseAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswerText whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswerText withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswerText withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireResponseAnswerText extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_response_answer_texts';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'questionnaire_id', 'questionnaire_response_id',
        'question_name', 'answer', 'parsed',
        'english_translation', 'initial_language_detected'
    ];
}
