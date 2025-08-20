<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\QuestionnaireStatusHistory
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $status_id
 * @property int $updated_by_user_id
 * @property string $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read QuestionnaireStatus $status
 */
class QuestionnaireStatusHistory extends Model {
    protected $table = 'questionnaire_status_history';

    public function status(): HasOne {
        return $this->hasOne(QuestionnaireStatus::class, 'id', 'status_id');
    }
}
