<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrowdSourcingProjectStatusHistory extends Model {
    use SoftDeletes;

    protected $table = 'crowd_sourcing_project_status_history';
    protected $fillable = [
        'project_id', 'status_id',
    ];
}
