<?php

namespace App\Repository\Questionnaire;

use App\Models\QuestionnairePossibleAnswer;
use App\Repository\Repository;

class QuestionnairePossibleAnswerRepository extends Repository {
    public function getModelClassName() {
        return QuestionnairePossibleAnswer::class;
    }
}
