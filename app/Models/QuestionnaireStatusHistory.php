<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/11/18
 * Time: 3:58 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireStatusHistory
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $status_id
 * @property string $comments
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\QuestionnaireStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireStatusHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuestionnaireStatusHistory extends Model
{
    protected $table = 'questionnaire_status_history';

    public function status()
    {
        return $this->hasOne(QuestionnaireStatus::class, 'id', 'status_id');
    }
}