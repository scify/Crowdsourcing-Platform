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
 * App\Models\QuestionnaireHtml
 *
 * @property int $id
 * @property int $question_id
 * @property string $html
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireHtml onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireHtml whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireHtml withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireHtml withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireHtml extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_html';
    protected $dates = ['deleted_at'];
}