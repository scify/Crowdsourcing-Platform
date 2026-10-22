<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\User\User;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponseReferral
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $respondent_id The user who clicked on the share link and answered the questionnaire
 * @property int $referrer_id The user who shared the link with the questionnaire
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Questionnaire $questionnaire
 * @property-read User $referrer
 * @property-read User $respondent
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereReferrerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereRespondentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponseReferral withoutTrashed()
 *
 * @mixin Eloquent
 */
class QuestionnaireResponseReferral extends Model {
    use SoftDeletes;

    protected $fillable = [
        'respondent_id', 'referrer_id', 'questionnaire_id',
    ];

    /**
     * The user who answered the questionnaire by following the link
     */
    public function respondent(): BelongsTo {
        return $this->belongsTo(User::class, 'respondent_id', 'id');
    }

    /**
     * The user who shared the questionnaire and invited users to respond to it.
     */
    public function referrer(): BelongsTo {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function questionnaire(): BelongsTo {
        return $this->belongsTo(Questionnaire::class);
    }
}
