<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
