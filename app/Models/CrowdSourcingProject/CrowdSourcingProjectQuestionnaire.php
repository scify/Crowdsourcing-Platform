<?php

declare(strict_types=1);

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\CrowdSourcingProject\CrowdSourcingProjectQuestionnaire
 *
 * @property int $project_id
 * @property int $questionnaire_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read CrowdSourcingProject|null $project
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectQuestionnaire whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CrowdSourcingProjectQuestionnaire extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_project_questionnaires';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id', 'questionnaire_id',
    ];

    protected $primaryKey = ['project_id', 'questionnaire_id'];

    public $incrementing = false;

    public function project(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id');
    }
}
