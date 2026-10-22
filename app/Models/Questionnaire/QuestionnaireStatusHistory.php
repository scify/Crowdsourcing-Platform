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
 * @property string|null $current_json
 * @property string|null $old_json
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereCurrentJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereOldJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatusHistory whereUpdatedByUserId($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireStatusHistory extends Model {
    protected $table = 'questionnaire_status_history';

    public function status(): HasOne {
        return $this->hasOne(QuestionnaireStatus::class, 'id', 'status_id');
    }
}
