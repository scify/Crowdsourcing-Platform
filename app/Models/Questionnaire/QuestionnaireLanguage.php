<?php

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
