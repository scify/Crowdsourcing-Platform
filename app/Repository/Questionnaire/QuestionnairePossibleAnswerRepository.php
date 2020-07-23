<?php


namespace App\Repository\Questionnaire;


use App\Models\QuestionnairePossibleAnswer;
use App\Repository\Repository;

class QuestionnairePossibleAnswerRepository extends Repository {

    function getModelClassName() {
        return QuestionnairePossibleAnswer::class;
    }
}
