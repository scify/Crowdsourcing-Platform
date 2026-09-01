<?php

declare(strict_types=1);

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\CrowdSourcingProjectStatusHistory
 *
 * @property int $id
 * @property int $project_id
 * @property int $status_id
 * @property string|null $comments
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereComments($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectStatusHistory withoutTrashed()
 *
 * @mixin \Eloquent
 */
class CrowdSourcingProjectStatusHistory extends Model {
    use SoftDeletes;

    protected $table = 'crowd_sourcing_project_status_history';

    protected $fillable = [
        'project_id', 'status_id',
    ];
}
