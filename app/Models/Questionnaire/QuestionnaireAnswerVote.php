<?php

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\QuestionnaireAnswerVote
 *
 * @property string $questionnaire_id
 * @property string $question_name
 * @property string $respondent_user_id
 * @property string $voter_user_id
 * @property bool $upvote
 * @property-read User $voter
 * @property-read User $respondent
 * @property-read Questionnaire $questionnaire
 */
class QuestionnaireAnswerVote extends CompositeKeysModel {
    use HasFactory;

    protected $table = 'questionnaire_answer_votes';
    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'respondent_user_id',
        'voter_user_id',
        'upvote',
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
