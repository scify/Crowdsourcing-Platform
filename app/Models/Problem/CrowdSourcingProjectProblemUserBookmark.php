<?php

namespace App\Models\Problem;

use App\Models\Language;
use App\Models\User\User;
use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CrowdSourcingProjectProblemUserBookmark extends Model {
    use Compoships;

    protected $table = 'csp_problem_user_bookmarks';
    protected $fillable = ['problem_id', 'user_id', 'problem_bookmark_language_id'];
    protected $primaryKey = ['problem_id', 'user_id'];
    public $incrementing = false;

    public function problem(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProjectProblem::class, 'problem_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class, 'problem_bookmark_language_id', 'id');
    }
}
