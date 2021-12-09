<?php

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnswerVote extends CompositeKeysModel {

    protected $table = 'questionnaire_answer_votes';

    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'respondent_user_id',
        'voter_user_id',
        'upvote'
    ];

    protected $primaryKey = ['questionnaire_id', 'question_name', 'respondent_user_id', 'voter_user_id'];
    public $incrementing = false;

    public function voter(): BelongsTo {
        return $this->belongsTo(User::class, 'voter_user_id', 'id');
    }

    public function respondent(): BelongsTo {
        return $this->belongsTo(User::class, 'respondent_user_id', 'id');
    }

    public function questionnaire(): BelongsTo {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id');
    }
}
