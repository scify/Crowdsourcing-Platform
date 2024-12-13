<?php

namespace App\Models\Solution;

use Illuminate\Database\Eloquent\Model;

class SolutionShare extends Model {
    protected $table = 'solution_shares';
    protected $fillable = [
        'solution_id',
        'user_id',
        'shared_at',
    ];
}
