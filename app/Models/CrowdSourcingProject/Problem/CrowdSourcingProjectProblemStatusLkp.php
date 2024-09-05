<?php

namespace App\Models\CrowdSourcingProject\Problem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class CrowdSourcingProjectProblemStatusLkp extends Model {
    public $timestamps = false;
    protected $table = 'csp_problem_statuses_lkp';
}
