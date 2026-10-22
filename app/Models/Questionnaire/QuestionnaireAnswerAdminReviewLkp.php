<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\QuestionnaireAnswerAdminReviewLkp
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireAnswerAdminReviewLkp withoutTrashed()
 *
 * @mixin \Eloquent
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
