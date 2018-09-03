<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponseAnswer
 *
 * @property int $id
 * @property int $questionnaire_response_id
 * @property int $question_id
 * @property int|null $answer_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswer onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereQuestionnaireResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseAnswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseAnswer withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireResponseAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_response_answers';
    protected $dates = ['deleted_at'];
}