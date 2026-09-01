<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\QuestionnaireStatus
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireType whereName($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireType extends Model {
    public $timestamps = false;

    protected $table = 'questionnaire_types';
}
