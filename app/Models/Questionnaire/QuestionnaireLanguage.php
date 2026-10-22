<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireLanguage
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $language_id
 * @property int $human_approved
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Language $language
 *
 * @method static \Database\Factories\Questionnaire\QuestionnaireLanguageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereHumanApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireLanguage withoutTrashed()
 *
 * @mixin \Eloquent
 */
class QuestionnaireLanguage extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'questionnaire_languages';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'questionnaire_id',
        'language_id',
        'human_approved',
        'color',
    ];

    public function language(): HasOne {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
