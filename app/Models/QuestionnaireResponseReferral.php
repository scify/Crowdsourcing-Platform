<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponseReferral
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $respondent_id The user who clicked on the share link and answered the questionnaire
 * @property int $referrer_id The user who shared the link with the questionnaire
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Questionnaire $questionnaire
 * @property-read \App\Models\User $referrer
 * @property-read \App\Models\User $respondent
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseReferral onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereReferrerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereRespondentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponseReferral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseReferral withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponseReferral withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireResponseReferral extends Model {
    use SoftDeletes;

    protected $fillable = [
        'respondent_id', 'referrer_id', 'questionnaire_id',
    ];

    /**
     * The user who answered the questionnaire by following the link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function respondent() {
        return $this->belongsTo(User::class, 'respondent_id', 'id');
    }

    /**
     * The user who shared the questionnaire and invited users to respond to it.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer() {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function questionnaire() {
        return $this->belongsTo(Questionnaire::class);
    }
}
