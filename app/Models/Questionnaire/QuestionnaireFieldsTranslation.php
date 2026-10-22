<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Carbon;

/**
 * App\Models\QuestionnaireFieldsTranslation
 *
 * @property string $questionnaire_id
 * @property string $language_id
 * @property string $title
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireFieldsTranslation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireFieldsTranslation extends CompositeKeysModel {
    use Compoships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'questionnaire_fields_translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'questionnaire_id', 'language_id', 'title', 'description',
    ];

    protected $primaryKey = ['questionnaire_id', 'language_id'];

    public $incrementing = false;
}
