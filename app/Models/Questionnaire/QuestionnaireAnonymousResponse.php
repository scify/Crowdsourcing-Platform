<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnonymousResponse extends Model {

    protected $table = 'questionnaire_anonymous_responses';
    protected $fillable = [
        'response_id',
        'browser_fingerprint_id',
        'browser_ip'
    ];

    public function response(): BelongsTo {
        return $this->belongsTo(QuestionnaireResponse::class, 'response_id', 'id');
    }

}
