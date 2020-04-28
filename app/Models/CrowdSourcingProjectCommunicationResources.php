<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectCommunicationResources extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_project_communication_resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'questionnaire_response_email_intro_text', 'questionnaire_response_email_outro_text',
        'should_send_email_after_questionnaire_response'
    ];

    public function project() {
        return $this->belongsTo(CrowdSourcingProject::class, 'communication_resource_id', 'id');
    }


}
