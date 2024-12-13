<?php

namespace App\Models\Solution;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionShare extends Model {
    protected $table = 'solution_shares';
    protected $fillable = [
        'solution_id',
        'user_id',
        'shared_at',
    ];

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }
}
