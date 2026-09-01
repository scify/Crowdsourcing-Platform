<?php

declare(strict_types=1);

namespace App\Models\Solution;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemSolutionStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolutionStatusLkp whereTitle($value)
 *
 * @mixin \Eloquent
 */
class SolutionStatusLkp extends Model {
    public $timestamps = false;

    protected $table = 'solution_statuses_lkp';
}
