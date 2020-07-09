<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|QuestionnaireResponse onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|QuestionnaireResponse whereCreatedAt($value)
 * @method static Builder|QuestionnaireResponse whereDeletedAt($value)
 * @method static Builder|QuestionnaireResponse whereId($value)
 * @method static Builder|QuestionnaireResponse whereQuestionnaireId($value)
 * @method static Builder|QuestionnaireResponse whereResponseJson($value)
 * @method static Builder|QuestionnaireResponse whereUpdatedAt($value)
 * @method static Builder|QuestionnaireResponse whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|QuestionnaireResponse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|QuestionnaireResponse withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireResponse extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_responses';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
