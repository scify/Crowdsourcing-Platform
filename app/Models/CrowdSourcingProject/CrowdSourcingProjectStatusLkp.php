<?php

declare(strict_types=1);

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectStatusLkp
 *
 * @property int $id
 * @property string $status_name
 * @property string $status_description
 * @property string $title
 * @property string $description
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusLkp whereTitle($value)
 *
 * @mixin \Eloquent
 */
class CrowdSourcingProjectStatusLkp extends Model {
    public $timestamps = false;

    protected $table = 'crowd_sourcing_project_statuses_lkp';
}
