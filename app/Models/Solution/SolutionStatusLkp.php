<?php

namespace App\Models\Solution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemSolutionStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class SolutionStatusLkp extends Model {
    public $timestamps = false;
    protected $table = 'solution_statuses_lkp';
}
