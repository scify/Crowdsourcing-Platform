<?php

namespace App\Models\CrowdSourcingProject\Problem;

use App\Models\CompositeKeysModel;
use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrowdSourcingProjectProblemTranslation extends CompositeKeysModel {
    use Compoships, HasFactory;

    protected $table = 'crowd_sourcing_project_problem_translations';
    protected $fillable = ['problem_id', 'language_id', 'title', 'description'];
    protected $primaryKey = ['problem_id', 'language_id'];
    public $incrementing = false;

    public function problem(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProjectProblem::class, 'problem_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
