<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireResponseToxicity extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_response_toxicities';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'questionnaire_response_id',
        'answer_text',
        'question_name',
        'toxicity_score',
        'toxicity_api_response'
    ];

    public function questionnaireResponse() {
        return $this->belongsTo(QuestionnaireResponse::class, 'questionnaire_response_id', 'id');
    }
}
