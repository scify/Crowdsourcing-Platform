<?php
namespace App\Models\Questionnaire;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireStatusHistory
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $status_id
 * @property string $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read QuestionnaireStatus $status
 */
class QuestionnaireStatusHistory extends Model
{
    protected $table = 'questionnaire_status_history';

    public function status()
    {
        return $this->hasOne(QuestionnaireStatus::class, 'id', 'status_id');
    }
}
