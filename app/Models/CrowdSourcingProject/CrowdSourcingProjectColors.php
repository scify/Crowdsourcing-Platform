<?php

namespace App\Models\CrowdSourcingProject;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CrowdSourcingProjectColors
 *
 * @property int $id
 * @property int $project_id
 * @property string $color_name
 * @property string $color_code
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
     * @var array
     */
    protected $fillable = [
        'project_id', 'color_name', 'color_code',
    ];
}
