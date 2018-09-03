<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/18/18
 * Time: 3:11 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireTranslationQuestion
 *
 * @property int $id
 * @property int $questionnaire_language_id
 * @property int $question_id
 * @property string $translation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationQuestion onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereQuestionnaireLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationQuestion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationQuestion withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationQuestion withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireTranslationQuestion extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_translation_questions';
}