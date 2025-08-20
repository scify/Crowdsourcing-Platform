<?php

declare(strict_types=1);

namespace App\Models\Solution;

use App\Models\CompositeKeysModel;
use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolutionTranslation extends CompositeKeysModel {
    use Compoships;
    use HasFactory;

    protected $table = 'solution_translations';

    protected $fillable = ['solution_id', 'language_id', 'title', 'description'];

    protected $primaryKey = ['solution_id', 'language_id'];

    public $incrementing = false;

    public function solution(): BelongsTo {
        return $this->belongsTo(Solution::class, 'solution_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
