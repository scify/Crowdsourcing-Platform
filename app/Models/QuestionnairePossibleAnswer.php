<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:48 PM
 */

namespace App\Models;


use Carbon\Carbon;
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
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class QuestionnairePossibleAnswer extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_possible_answers';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'question_id',
        'guid',
        'value',
        'answer',
        'color'
    ];
}
