<?php

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\QuestionnaireAnswerAnnotation
 *
 * @property string $questionnaire_id
 * @property string $question_name
 * @property string $respondent_user_id
 * @property string $annotator_user_id
 * @property string $annotation_text
 * @property string $admin_review_status_id
 * @property string $admin_review_comment
 * @property-read User $annotator
 * @property-read User $respondent
 * @property-read Questionnaire $questionnaire
 * @property-read QuestionnaireAnswerAdminReviewLkp $adminReviewStatusLkp
 */
class QuestionnaireAnswerAnnotation extends CompositeKeysModel {
    protected $table = 'questionnaire_answer_annotations';
    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'respondent_user_id',
        'annotator_user_id',
        'annotation_text',
        'admin_review_status_id',
        'admin_review_comment',
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

    public function adminReviewStatusLkp(): HasOne {
        return $this->hasOne(QuestionnaireAnswerAdminReviewLkp::class, 'id', 'admin_review_status_id');
    }
}
