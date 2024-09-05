<?php

namespace App\Models\CrowdSourcingProject\Problem\Solution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemSolutionStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class CrowdSourcingProjectProblemSolutionStatusLkp extends Model {
    public $timestamps = false;
    protected $table = 'csp_problem_solution_statuses_lkp';
}
