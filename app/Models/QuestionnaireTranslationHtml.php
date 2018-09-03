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
 * App\Models\QuestionnaireTranslationHtml
 *
 * @property int $id
 * @property int $questionnaire_language_id
 * @property int $html_id
 * @property string $translation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationHtml onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereHtmlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereQuestionnaireLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereTranslation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireTranslationHtml whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationHtml withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireTranslationHtml withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireTranslationHtml extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_translation_html';
}