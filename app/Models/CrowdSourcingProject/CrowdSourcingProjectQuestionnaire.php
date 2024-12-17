<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CrowdSourcingProject\CrowdSourcingProjectQuestionnaire
 *
 * @property int $project_id
 * @property int $questionnaire_id
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
     * @var array
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
