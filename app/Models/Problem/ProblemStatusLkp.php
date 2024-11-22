<?php

namespace App\Models\Problem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class ProblemStatusLkp extends Model {
    public $timestamps = false;
    protected $table = 'problem_statuses_lkp';
}
