<?php

namespace App\Models\Questionnaire;


use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\Language;
use App\Models\Questionnaire\Statistics\QuestionnaireBasicStatisticsColors;
use App\Models\Questionnaire\Statistics\QuestionnaireStatisticsPageVisibilityLkp;
use App\Models\QuestionnaireQuestion;
use Awobaz\Compoships\Compoships;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
class Questionnaire extends Model {
    use SoftDeletes;
    use Compoships;

    protected $table = 'questionnaires';
    protected $fillable = [
        'project_id',
        'prerequisite_order',
        'status_id',
        'default_language_id',
        'goal',
        'questionnaire_json',
        'statistics_page_visibility_lkp_id'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['defaultFieldsTranslation'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'id';
    }

    public function defaultLanguage() {
        return $this->hasOne(Language::class, 'id', 'default_language_id');
    }

    /**
     * The users that belong to the role.
     * @return BelongsToMany
     */
    public function projects() {
        return $this->belongsToMany(
            CrowdSourcingProject::class,
            'crowd_sourcing_project_questionnaires',
            'questionnaire_id',
            'project_id');
    }

    public function statusHistory() {
        return $this->hasMany(QuestionnaireStatusHistory::class, 'questionnaire_id', 'id');
    }

    public function questionnaireLanguages() {
        return $this->hasMany(QuestionnaireLanguage::class, 'questionnaire_id', 'id');
    }

    public function languages() {
        return $this->belongsToMany(
            Language::class, // target model
            QuestionnaireLanguage::class, // intermediate model
            'questionnaire_id', // Foreign key of this model on the intermediate table
            'language_id', // Foreign key of target model on the intermediate table
            'id', // Local key on intermediate table
            'id' // Local key on target table
        );
    }

    public function responses() {
        return $this->hasMany(QuestionnaireResponse::class, 'questionnaire_id', 'id');
    }

    public function statisticsPageVisibilityStatus() {
        return $this->hasOne(QuestionnaireStatisticsPageVisibilityLkp::class, 'id', 'statistics_page_visibility_lkp_id');
    }

    public function basicStatisticsColors() {
        return $this->hasOne(QuestionnaireBasicStatisticsColors::class, 'questionnaire_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function defaultFieldsTranslation() {
        return $this->hasOne(QuestionnaireFieldsTranslation::class,
            ['questionnaire_id', 'language_id'], ['id', 'default_language_id'])->withDefault([
            'title' => 'Questionnaire title',
            'description' => 'Questionnaire description'
        ]);
    }

    /**
     * @return HasMany
     */
    public function fieldsTranslations() {
        return $this->hasMany(QuestionnaireFieldsTranslation::class, 'questionnaire_id', 'id');
    }
}
