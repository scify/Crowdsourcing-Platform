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
 */
class QuestionnaireType extends Model {
    public $timestamps = false;

    protected $table = 'questionnaire_types';
}
