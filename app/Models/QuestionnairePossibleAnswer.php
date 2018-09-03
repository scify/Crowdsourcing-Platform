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
 * App\Models\QuestionnairePossibleAnswer
 *
 * @property int $id
 * @property int $question_id
 * @property string $guid
 * @property string|null $value
 * @property string $answer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnairePossibleAnswer onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereGuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnairePossibleAnswer whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnairePossibleAnswer withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnairePossibleAnswer withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnairePossibleAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_possible_answers';
    protected $dates = ['deleted_at'];
}