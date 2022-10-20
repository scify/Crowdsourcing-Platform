<?php

namespace App\Models\Questionnaire;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponse
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $user_id
 * @property int $language_id
 * @property string $response_json
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read User $user
 */
class QuestionnaireResponse extends Model {
    use SoftDeletes;

    protected $table = 'questionnaire_responses';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'questionnaire_id',
        'project_id',
        'user_id',
        'language_id',
        'response_json',
        'response_json_translated',
        'browser_fingerprint_id',
        'browser_ip',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function questionnaire() {
        return $this->belongsTo(Questionnaire::class)->withTrashed();
    }

    public function project() {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }
}
