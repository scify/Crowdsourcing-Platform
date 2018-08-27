<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireResponseReferral extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'respondent_id', 'referrer_id', 'questionnaire_id'
    ];

    /**
     * The user who answered the questionnaire by following the link
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function respondent()
    {
        return $this->belongsTo(User::class, 'respondent_id', 'id');
    }

    /**
     * The user who shared the questionnaire and invited users to respond to it.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
