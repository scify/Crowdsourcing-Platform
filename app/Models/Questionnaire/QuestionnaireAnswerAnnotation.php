<?php

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnswerAnnotation extends CompositeKeysModel
{
    protected $table = 'questionnaire_answer_annotations';

    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'respondent_user_id',
        'annotator_user_id',
        'annotation_text'
    ];

    protected $primaryKey = ['questionnaire_id', 'question_name', 'respondent_user_id'];
    public $incrementing = false;

    public function annotator(): BelongsTo {
        return $this->belongsTo(User::class, 'annotator_user_id', 'id');
    }

    public function respondent(): BelongsTo {
        return $this->belongsTo(User::class, 'respondent_user_id', 'id');
    }

    public function questionnaire(): BelongsTo {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id');
    }
}
