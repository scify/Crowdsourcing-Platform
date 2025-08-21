<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\CompositeKeysModel;
use Awobaz\Compoships\Compoships;

/**
 * App\Models\QuestionnaireFieldsTranslation
 *
 * @property string $questionnaire_id
 * @property string $language_id
 * @property string $title
 * @property string $description
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
     * @var array
     */
    protected $fillable = [
        'questionnaire_id', 'language_id', 'title', 'description',
    ];

    protected $primaryKey = ['questionnaire_id', 'language_id'];

    public $incrementing = false;
}
