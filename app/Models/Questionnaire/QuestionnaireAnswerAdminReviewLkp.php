<?php

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireAnswerAdminReviewLkp extends Model
{
    use SoftDeletes;
    protected $table = 'questionnaire_answer_admin_review_lkp';

    protected $fillable = [
        'id',
        'name',
        'description'
    ];
}
