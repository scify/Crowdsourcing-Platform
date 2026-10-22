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
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireStatus whereTitle($value)
 *
 * @mixin \Eloquent
 */
class QuestionnaireStatus extends Model {
    public $timestamps = false;

    protected $table = 'questionnaire_statuses_lkp';
}
