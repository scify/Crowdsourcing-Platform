<?php

namespace App\Models\Questionnaire;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnswerVote extends Model {

    protected $table = 'questionnaire_answer_votes';

    protected $fillable = [
        'questionnaire_id',
        'question_name',
        'respondent_user_id',
        'voter_user_id',
        'upvote'
    ];

    protected $primaryKey = ['questionnaire_id', 'question_name', 'respondent_user_id', 'voter_user_id'];
    public $incrementing = false;

    public function voter(): BelongsTo {
        return $this->belongsTo(User::class, 'voter_user_id', 'id');
    }

    public function respondent(): BelongsTo {
        return $this->belongsTo(User::class, 'respondent_user_id', 'id');
    }

    public function questionnaire(): BelongsTo {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id', 'id');
    }

    /**
     * Set the keys for a save update query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
