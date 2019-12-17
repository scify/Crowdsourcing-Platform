<?php

namespace App\Repository;


use App\Models\QuestionnaireResponseAnswerText;
use Illuminate\Support\Facades\DB;

class QuestionnaireResponseAnswerRepository {

    public function getNonTranslatedAnswers() {
        return DB::table('questionnaire_response_answer_texts')
            ->where(['english_translation' => null])
            ->limit(100)
            ->get();
    }

    public function getResponseTextDataForQuestionnaire($questionnaireId) {
        return DB::table('questionnaire_response_answers')
            ->join('questionnaire_questions', 'questionnaire_response_answers.question_id', '=', 'questionnaire_questions.id')
            ->join('questionnaire_response_answer_texts',
                'questionnaire_response_answer_texts.questionnaire_response_answer_id', '=', 'questionnaire_response_answers.id')
            ->where(['questionnaire_questions.questionnaire_id' => $questionnaireId])
            ->select('questionnaire_response_answers.*', 'questionnaire_response_answer_texts.*')
            ->get();
    }
}
