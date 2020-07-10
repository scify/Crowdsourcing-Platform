<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Questionnaire onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Questionnaire whereCreatedAt($value)
 * @method static Builder|Questionnaire whereDefaultLanguageId($value)
 * @method static Builder|Questionnaire whereDeletedAt($value)
 * @method static Builder|Questionnaire whereDescription($value)
 * @method static Builder|Questionnaire whereGoal($value)
 * @method static Builder|Questionnaire whereId($value)
 * @method static Builder|Questionnaire whereProjectId($value)
 * @method static Builder|Questionnaire whereQuestionnaireJson($value)
 * @method static Builder|Questionnaire whereStatusId($value)
 * @method static Builder|Questionnaire whereTitle($value)
 * @method static Builder|Questionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Questionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Questionnaire withoutTrashed()
 * @mixin \Eloquent
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
}
