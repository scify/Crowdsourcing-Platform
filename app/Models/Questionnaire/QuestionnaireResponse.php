<?php

declare(strict_types=1);

namespace App\Models\Questionnaire;

use App\Models\CrowdSourcingProject\CrowdSourcingProject;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property int|null $project_id
 * @property string|null $browser_fingerprint_id
 * @property string|null $browser_ip
 * @property string|null $response_json_translated
 * @property-read CrowdSourcingProject|null $project
 * @property-read Questionnaire|null $questionnaire
 *
 * @method static \Database\Factories\Questionnaire\QuestionnaireResponseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereBrowserFingerprintId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereBrowserIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereResponseJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereResponseJsonTranslated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuestionnaireResponse withoutTrashed()
 *
 * @mixin \Eloquent
 */
class QuestionnaireResponse extends Model {
    use HasFactory;
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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function questionnaire(): BelongsTo {
        return $this->belongsTo(Questionnaire::class)->withTrashed();
    }

    public function project(): BelongsTo {
        return $this->belongsTo(CrowdSourcingProject::class, 'project_id', 'id');
    }
}
