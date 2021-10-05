<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;

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
        'project_id', 'questionnaire_id'
    ];
    protected $primaryKey = ['project_id', 'questionnaire_id'];
    public $incrementing = false;
}
