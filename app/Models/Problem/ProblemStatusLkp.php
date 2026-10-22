<?php

declare(strict_types=1);

namespace App\Models\Problem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectProblemStatusLkp
 *
 * @property int $id
 * @property string $title
 * @property string $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProblemStatusLkp whereTitle($value)
 *
 * @mixin \Eloquent
 */
class ProblemStatusLkp extends Model {
    public $timestamps = false;

    protected $table = 'problem_statuses_lkp';
}
