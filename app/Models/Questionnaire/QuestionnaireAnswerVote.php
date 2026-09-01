<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Database\Factories\Questionnaire\QuestionnaireAnswerVoteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereQuestionName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereRespondentUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereUpvote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerVote whereVoterUserId($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireAnswerVote extends CompositeKeysModel {
    use HasFactory;

    // Votes are soft-deleted when a user is deleted, and restored together
    // with the user (UserManager). See restoreAnswerVotesByUser().
    use SoftDeletes;

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
