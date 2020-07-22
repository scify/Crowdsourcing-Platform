<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use App\Models\Questionnaire\Statistics\QuestionnaireBasicStatisticsColors;
use App\Models\Questionnaire\Statistics\QuestionnaireLanguageStatisticsColor;
use App\Models\Questionnaire\Statistics\QuestionnaireQuestionStatisticsColor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Questionnaire
 *
 * @property int $id
 * @property int $project_id
 * @property int $status_id
 * @property int $default_language_id
 * @property string $title
 * @property string $description
 * @property int $goal
 * @property string $questionnaire_json
 * @property int $statistics_page_visibility_lkp_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Language $defaultLanguage
 * @property-read CrowdSourcingProject $project
 * @property-read Collection|QuestionnaireStatusHistory[] $statusHistory
 * @property-read Collection|QuestionnaireResponse[] $responses
 * @property-read QuestionnaireStatisticsPageVisibilityLkp $statisticsPageVisibilityStatus
 * @property-read QuestionnaireBasicStatisticsColors $basicStatisticsColors
 * @property-read Collection|QuestionnaireLanguageStatisticsColor[] $languageStatisticsColors
 */
class Questionnaire extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaires';
    protected $fillable = [
        'project_id',
        'prerequisite_order',
        'status_id',
        'default_language_id',
        'title',
        'description',
        'goal',
        'questionnaire_json',
        'statistics_page_visibility_lkp_id'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    public function defaultLanguage()
    {
        return $this->hasOne(Language::class, 'id', 'default_language_id');
    }

    public function project()
    {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }

    public function statusHistory()
    {
        return $this->hasMany(QuestionnaireStatusHistory::class, 'questionnaire_id', 'id');
    }

    public function responses()
    {
        return $this->hasMany(QuestionnaireResponse::class, 'questionnaire_id', 'id');
    }

    public function statisticsPageVisibilityStatus()
    {
        return $this->hasOne(QuestionnaireStatisticsPageVisibilityLkp::class, 'id', 'statistics_page_visibility_lkp_id');
    }

    public function basicStatisticsColors()
    {
        return $this->hasOne(QuestionnaireBasicStatisticsColors::class, 'questionnaire_id', 'id');
    }

    public function languageStatisticsColors()
    {
        return $this->hasMany(QuestionnaireLanguageStatisticsColor::class, 'questionnaire_id', 'id');
    }

    public function questionStatisticsColors() {
        return $this->belongsToMany(
            QuestionnaireQuestionStatisticsColor::class, // The model to access to
            'questionnaire_questions', // The intermediate table that connects the current Model to the intermediate one.
            'questionnaire_id', // The column of the intermediate table that connects to this model by its ID.
            'questionnaire_question_id', // The column of the intermediate table that connects the intermediate Model by its ID.
            'id', // The column that ties this model with the intermediate model table.
            'id' // The column of the target Model table that ties it to the intermediate.
        );
    }
}
