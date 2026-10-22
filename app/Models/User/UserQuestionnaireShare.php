<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Questionnaire\Questionnaire;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserQuestionnaireShare
 *
 * @property int $id
 * @property int $user_id
 * @property int $questionnaire_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read Questionnaire $questionnaire
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserQuestionnaireShare withoutTrashed()
 *
 * @mixin Eloquent
 */
class UserQuestionnaireShare extends Model {
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'questionnaire_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function questionnaire() {
        return $this->belongsTo(Questionnaire::class);
    }
}
