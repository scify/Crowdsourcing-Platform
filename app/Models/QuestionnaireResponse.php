<?php
/**
 * Created by IntelliJ IDEA.
 * User: snik
 * Date: 7/9/18
 * Time: 5:35 PM
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\QuestionnaireResponse
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property int $user_id
 * @property string $response_json
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponse onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereResponseJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\QuestionnaireResponse whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponse withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\QuestionnaireResponse withoutTrashed()
 * @mixin \Eloquent
 */
class QuestionnaireResponse extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_responses';
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}