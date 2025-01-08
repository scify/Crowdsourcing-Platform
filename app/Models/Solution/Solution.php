<?php

namespace App\Models\Solution;

use App\Models\Problem\Problem;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solution extends Model {
    use HasFactory, SoftDeletes;

    protected $table = 'solutions';
    protected $fillable = ['id', 'problem_id', 'user_creator_id', 'slug', 'status_id', 'img_url'];
    protected $with = ['defaultTranslation'];

    // problem relationship (a solution belongs to a problem)
    public function problem(): BelongsTo {
        return $this->belongsTo(Problem::class, 'problem_id');
    }

    // default translation relationship
    // the solution has the same default translation as the problem it belongs to.
    // but the records are stored in different tables (solution_translations and problem_translations)
    // so we need to take the default_language_id from the problem and use it to get the translation
    public function defaultTranslation(): HasOne {
        return $this->hasOne(SolutionTranslation::class, 'solution_id')
            ->join('solutions', 'solution_translations.solution_id', '=', 'solutions.id')
            ->join('problems', 'problems.id', '=', 'solutions.problem_id')
            ->whereColumn('solution_translations.language_id', 'problems.default_language_id')
            ->select('solution_translations.*');
    }

    public function translations(): HasMany {
        return $this->hasMany(SolutionTranslation::class, 'solution_id', 'id');
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'user_creator_id', 'id');
    }

    public function status(): BelongsTo {
        return $this->belongsTo(SolutionStatusLkp::class, 'status_id');
    }

    public function upvotes(): HasMany {
        return $this->hasMany(SolutionUpvote::class, 'solution_id', 'id');
    }

    public function shares(): HasMany {
        return $this->hasMany(SolutionShare::class, 'solution_id', 'id');
    }
}
