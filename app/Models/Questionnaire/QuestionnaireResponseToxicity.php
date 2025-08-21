<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\QuestionnaireResponseToxicity
 *
 * @property int $id
 * @property int $questionnaire_response_id
 * @property string $answer_text
 * @property string $question_name
 * @property int $toxicity_score
 * @property string $toxicity_api_response
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read QuestionnaireResponse $questionnaireResponse
 */
class QuestionnaireResponseToxicity extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_response_toxicities';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'questionnaire_response_id',
        'answer_text',
        'question_name',
        'toxicity_score',
        'toxicity_api_response',
    ];

    public function questionnaireResponse(): BelongsTo {
        return $this->belongsTo(QuestionnaireResponse::class, 'questionnaire_response_id', 'id');
    }
}
