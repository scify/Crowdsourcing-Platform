<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:48 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireQuestion
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $guid
 * @property int $order_id
 * @property string $name
 * @property string $question
 * @property string $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireQuestion onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireQuestion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireQuestion withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_questions';
    protected $dates = ['deleted_at'];
}