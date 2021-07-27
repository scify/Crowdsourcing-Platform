<?php
namespace App\Models\Questionnaire;


use App\Models\Language;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireLanguage
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $language_id
 * @property int $machine_generated_translation
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Language $language

 */
class QuestionnaireLanguage extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_languages';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'questionnaire_id',
        'language_id',
        'machine_generated_translation',
        'color'
    ];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}
