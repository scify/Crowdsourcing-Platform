<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectStatusLkp
 *
 * @property int $id
 * @property string $status_name
 * @property string $status_description
 */
class CrowdSourcingProjectStatusLkp extends Model {
    public $timestamps = false;
    protected $table = 'crowd_sourcing_project_statuses_lkp';
}
