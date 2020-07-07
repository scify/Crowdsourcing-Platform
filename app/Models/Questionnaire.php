<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


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
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\Language $defaultLanguage
 * @property-read \App\Models\CrowdSourcingProject $project
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\QuestionnaireStatusHistory[] $statusHistory
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Questionnaire onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereDefaultLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereQuestionnaireJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Questionnaire whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Questionnaire withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Questionnaire withoutTrashed()
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
        'questionnaire_json'
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
}
