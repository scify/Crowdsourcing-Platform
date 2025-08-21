<?php

declare(strict_types=1);

namespace App\Models\Problem;

use App\Models\CompositeKeysModel;
use App\Models\Language;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProblemTranslation extends CompositeKeysModel {
    use Compoships;
    use HasFactory;

    protected $table = 'problem_translations';

    protected $fillable = ['problem_id', 'language_id', 'title', 'description'];

    protected $primaryKey = ['problem_id', 'language_id'];

    public $incrementing = false;

    public function problem(): BelongsTo {
        return $this->belongsTo(Problem::class, 'problem_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
