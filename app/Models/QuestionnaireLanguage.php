<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:43 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireLanguage
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $language_id
 * @property int $machine_generated_translation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Language $language
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireLanguage onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereMachineGeneratedTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireLanguage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireLanguage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireLanguage withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireLanguage extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_languages';
    protected $dates = ['deleted_at'];

    public function language()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }
}