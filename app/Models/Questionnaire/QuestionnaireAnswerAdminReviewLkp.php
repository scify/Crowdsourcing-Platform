<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireAnswerAdminReviewLkp
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class QuestionnaireAnswerAdminReviewLkp extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_answer_admin_review_lkp';
    protected $fillable = [
        'id',
        'name',
        'description',
    ];
}
