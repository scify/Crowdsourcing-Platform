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
 * App\Models\QuestionnaireQuestion
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $guid
 * @property int $order_id
 * @property string $name
 * @property string $question
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at

 */
class QuestionnaireQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_questions';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'questionnaire_id',
        'guid',
        'order_id',
        'name',
        'question',
        'type'
    ];

    public function possibleAnswers()
    {
        return $this->hasMany(QuestionnairePossibleAnswer::class, 'question_id', 'id');
    }
}
