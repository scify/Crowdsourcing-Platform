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

    public function questions()
    {
        return $this->hasMany(QuestionnaireQuestion::class, 'questionnaire_id', 'id');
    }

    public function questionnaireLanguages()
    {
        return $this->hasMany(QuestionnaireLanguage::class, 'questionnaire_id', 'id');
    }

    public function languages()
    {
        return $this->belongsToMany(
            Language::class, // target model
            QuestionnaireLanguage::class, // intermediate model
            'questionnaire_id', // Foreign key of this model on the intermediate table
            'language_id', // Foreign key of target model on the intermediate table
            'id', // Local key on intermediate table
            'id' // Local key on target table
        );
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
}
