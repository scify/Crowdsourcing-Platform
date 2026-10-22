<?php

declare(strict_types=1);

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CrowdSourcingProjectColors
 *
 * @property int $id
 * @property int $project_id
 * @property string $color_name
 * @property string $color_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereColorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereColorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CrowdSourcingProjectColors whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CrowdSourcingProjectColors extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crowd_sourcing_project_colors';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'project_id', 'color_name', 'color_code',
    ];
}
