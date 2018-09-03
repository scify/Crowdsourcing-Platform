<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserQuestionnaireShare
 *
 * @property int $id
 * @property int $user_id
 * @property int $questionnaire_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Questionnaire $questionnaire
 * @property-read \App\Models\User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserQuestionnaireShare onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereQuestionnaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserQuestionnaireShare whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserQuestionnaireShare withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserQuestionnaireShare withoutTrashed()
 * @mixin \Eloquent
 */
class UserQuestionnaireShare extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'questionnaire_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
