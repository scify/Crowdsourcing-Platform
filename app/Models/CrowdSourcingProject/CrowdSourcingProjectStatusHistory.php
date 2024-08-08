<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\CrowdSourcingProjectStatusHistory
 *
 * @property int $id
 * @property int $project_id
 * @property int $status_id
 */
class CrowdSourcingProjectStatusHistory extends Model {
    use SoftDeletes;

    protected $table = 'crowd_sourcing_project_status_history';
    protected $fillable = [
        'project_id', 'status_id',
    ];
}
